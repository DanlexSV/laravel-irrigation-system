<template>
  <Head title="Nuevo Dispositivo" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Vincular Dispositivo
      </h2>
    </template>

    <div
      v-if="summaryErrors.length"
      class="mx-auto max-w-5xl px-6 pt-6"
    >
      <div class="bg-red-100 text-red-800 p-4 rounded-xl">
        Se han detectado errores en:
        {{ summaryErrors.join(', ') }}. Revisa los campos marcados en rojo.
      </div>
    </div>

    <div class="py-6">
      <div class="mx-auto max-w-5xl px-6">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

          <DevicesPanel
    	    :devices="devices"
	    :selected-id="selectedDeviceId"
	    @add="addDevice"
	    @select="selectDevice"
	    @remove="removeDevice"
	  />

	  <DeviceEditor
	    :selected-device="selectedDevice"
	    :selected-index="selectedDeviceIndex"
	    :floors="floors"
	    :search="search"
	    :can-save="canSave"
	    :device-errors="deviceErrors"
	    :is-loading="isLoading"
	    @update:search="search = $event"
	    @search="doSearch"
	    @paginate="changePage"
	    @select-plant="setPlantForDevice"
	    @format-mac="formatMacInput"
	    @save="submitAll"
	  />
	</div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, Link, useForm } from '@inertiajs/vue3'

import DevicesPanel from '@/Pages/Device/Designs/DevicesPanel.vue'
import DeviceEditor from '@/Pages/Device/Designs/DeviceEditor.vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faTrash, faPlus } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faTrash, faPlus)

const search = ref('')
const floors = ref({ data: [] })
const selectedFloor = ref(null)
const isLoading = ref(false)

const fetchFloors = async (url = '/floors/list') => {
  isLoading.value = true
  try {
    const res = await axios.get(url, {
      params: search.value.trim() ? { search: search.value } : {}
    })
    floors.value = res.data
  } catch (err) {
    console.error('Error al cargar floors:', err)
  } finally {
    isLoading.value = false
  }
}

const changePage   = url   => fetchFloors(url)
const selectFloor  = floor => (selectedFloor.value = floor)

const doSearch = async () => {
  if (search.value.trim() === '') {
    return fetchFloors()
  }

  isLoading.value = true
  try {
    const res = await axios.get('/floors/searc', {
      params: { search: search.value }
    })
    floors.value = res.data
  } catch (err) {
    console.error('Error al buscar:', err)
  } finally {
    isLoading.value = false
  }
}

onMounted(fetchFloors)

const macAddresses = ref([{ value: '' }])
const errors = ref({})

const devices = ref([])
const nextId = ref(1)
const selectedDeviceId = ref(null)

const selectedDeviceIndex = computed(() =>
  devices.value.findIndex(d => d.id === selectedDeviceId.value)
)
const selectedDevice = computed(() =>
  selectedDeviceIndex.value !== -1 ? devices.value[selectedDeviceIndex.value] : null
)

const addDevice = () => {
  devices.value.push({
    id: nextId.value++,
    mac: '',
    floor: null,
    water_frequency: null,
    sunlight: ''
  })
  selectedDeviceId.value = devices.value.at(-1).id
}

const removeDevice = (id) => {
  const idx = devices.value.findIndex(d => d.id === id)
  if (idx !== -1) devices.value.splice(idx, 1)
  if (selectedDeviceId.value === id) selectedDeviceId.value = null

  if (devices.value.length === 0) nextId.value = 1
}

const selectDevice = (id) => {
  selectedDeviceId.value = id
}

const deviceErrors = ref({})

const formatMacInput = (idx) => {
  const val = devices.value[idx].mac
  devices.value[idx].mac = (
    val.replace(/[^a-fA-F0-9]/g, '')
       .toUpperCase()
       .match(/.{1,2}/g)?.join(':')
       .slice(0, 17)
  ) || ''
}

const setPlantForDevice = (floor) => {
  if (!selectedDevice.value) return

  selectedDevice.value.floor            = floor
  selectedDevice.value.water_frequency  = floor.water_frequency ?? ''
  selectedDevice.value.sunlight         = floor.sunlight        ?? ''
}

const canSave = computed(() =>
  devices.value.length > 0 &&
  devices.value.every(d =>
    d.mac &&
    d.floor &&
    d.water_frequency &&
    d.sunlight
  )
)

const summaryErrors = computed(() =>
  Object.keys(deviceErrors.value).map(i => `Dispositivo ${+i + 1}`)
)

const submitAll = async () => {
  if (!canSave.value) return

  deviceErrors.value = {}

  devices.value.forEach((d, idx) => {
    const macOk = /^([0-9A-F]{2}:){5}[0-9A-F]{2}$/.test(d.mac)

    if (!macOk) {
      deviceErrors.value[idx] = 'La dirección MAC no tiene el formato correcto'
    } else if (!d.floor) {
      deviceErrors.value[idx] = 'Debes seleccionar una planta'
    } else if (!d.water_frequency || d.water_frequency < 1) {
      deviceErrors.value[idx] = 'La frecuencia de riego es obligatoria'
    } else if (!d.sunlight) {
      deviceErrors.value[idx] = 'Selecciona el nivel de luz solar'
    }
  })

  if (Object.keys(deviceErrors.value).length) return

  const payload = devices.value.map(d => ({
    mac: d.mac,
    planta_id: d.floor.id,
    water_frequency: d.water_frequency,
    sunlight: d.sunlight
  }))

  try {
    router.post('/device/store', { devices: payload })
  } catch (err) {
    if (err.response?.status === 422) {
      const errors = err.response.data.errors

      Object.entries(errors).forEach(([key, msgs]) => {
        const match = key.match(/devices\.(\d+)\./)
        if (match) deviceErrors.value[match[1]] = msgs[0]
      })
    } else {
      console.error(err)
    }
  }
}
</script>
