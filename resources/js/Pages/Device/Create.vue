<template>
  <Head title="Nuevo Dispositivo" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Vincular Dispositivo
      </h2>
    </template>

<div class="py-6">
  <!-- 𝗖𝗼𝗻𝘁𝗲𝗻𝗲𝗱𝗼𝗿 𝗺á𝘀 𝗮𝗻𝗰𝗵𝗼 -->
  <div class="mx-auto max-w-5xl px-6">          <!-- 5xl ≈ 80 rem -->

    <!-- 𝗚𝗿𝗶𝗱 𝟭/𝟯 – 𝟮/𝟯 -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <!-- ░░░ 𝗖𝗢𝗟𝗨𝗠𝗡𝗔 𝗜𝗭𝗤𝗨𝗜𝗘𝗥𝗗𝗔 (1/3) ░░░ -->
      <section class="bg-white p-6 rounded-xl shadow-sm flex flex-col gap-4">
        <!-- Agregar dispositivo -->
        <button
          type="button"
          @click="addDevice"
          class="bg-brand hover:bg-brand-dark text-white px-4 py-2 rounded-xl text-sm"
        >
          Agregar dispositivo
        </button>

        <!-- Lista de dispositivos -->
	<div
	  v-for="(device, idx) in devices"
	  :key="device.id"
	  class="flex items-center gap-2"
	>
	  <button
	    @click="selectDevice(device.id)"
	    class="flex-1 text-left px-3 py-2 rounded border transition"
	    :class="device.id === selectedDeviceId
	      ? 'bg-brand-light text-brand border-brand'
	      : 'bg-white hover:bg-gray-50 border-gray-200'"
	  >
	    Dispositivo {{ idx + 1 }}       <!-- ← se muestra 1, 2, 3… -->
	  </button>

	  <button
	    @click="removeDevice(device.id)"
	    class="text-red-600 hover:text-red-800"
	    title="Eliminar dispositivo"
	  >
	    <FontAwesomeIcon icon="trash" />
	  </button>
	</div>
      </section>

      <!-- ░░░ 𝗖𝗢𝗟𝗨𝗠𝗡𝗔 𝗗𝗘𝗥𝗘𝗖𝗛𝗔 (2/3) ░░░ -->
      <section class="bg-white p-6 rounded-xl shadow-sm lg:col-span-2 flex flex-col gap-6">

        <!-- 𝗖𝗢𝗡𝗧𝗘𝗡𝗜𝗗𝗢 𝗗𝗬𝗡𝗔𝗠𝗜𝗖𝗢 -->
        <template v-if="selectedDevice">
          <!-- 1. Selección de planta -->
          <h3 class="font-semibold mb-4">Selecciona una planta</h3>

          <SearchBar
            v-model="search"
            placeholder="Buscar planta..."
            @search="doSearch"
          />

          <TableFloor
            :floors="floors"
            :selected="selectedDevice.floor"
	    @select="setPlantForDevice"
            @paginate="changePage"
          />

	  <!-- 3. Campos adicionales -->
	<div class="flex gap-4 mt-6">
		  <div class="flex-1">
	    <label class="block text-sm mb-1 font-semibold">
	      Frecuencia de riego (días)
	    </label>
	    <input
	      v-model.number="selectedDevice.water_frequency"
	      type="number"
	      min="1"
	      class="w-full border border-gray-300 rounded px-3 py-2"
	    />
	  </div>

	  <div class="flex-1">
	    <label class="block text-sm mb-1 font-semibold">
	      Luz solar
	    </label>

	    <select
	      v-model="selectedDevice.sunlight"
	      class="w-full border border-gray-300 rounded px-3 py-2 bg-white"
	    >
	      <option value="" disabled>Seleccione…</option>
	      <option value="Nula">Nula</option>
	      <option value="Baja">Baja</option>
	      <option value="Media">Media</option>
	      <option value="Alta">Alta</option>
	    </select>
	  </div>
	</div>

          <!-- 2. Input MAC -->
          <div class="mt-6">
            <label class="block text-sm mb-1 font-semibold">Dirección MAC</label>
            <input
              v-model="selectedDevice.mac"
              @input="formatMacInput(selectedDeviceIndex)"
              type="text"
              placeholder="00:1A:2B:3C:4D:5E"
              class="w-full rounded px-3 py-2 border"
              :class="deviceErrors[selectedDeviceIndex] ? 'border-red-500' : 'border-gray-300'"
            />
            <span
              v-if="deviceErrors[selectedDeviceIndex]"
              class="text-red-600 text-sm"
            >
              {{ deviceErrors[selectedDeviceIndex] }}
            </span>
          </div>
        </template>

        <!-- 𝗠𝗲𝗻𝘀𝗮𝗷𝗲 𝗱𝗲𝗳𝗲𝗰𝘁𝗼 -->
        <template v-else>
          <p class="text-gray-500 italic flex-1 flex items-center justify-center">
            No hay ningún dispositivo seleccionado
          </p>
        </template>

        <!-- 𝗚𝘂𝗮𝗿𝗱𝗮𝗿 -->
        <button
          type="button"
          @click="submitAll"
          :disabled="!canSave"
          class="self-end bg-brand-dark text-white px-6 py-2 rounded-2xl
                 disabled:opacity-60 disabled:cursor-not-allowed"
        >
          Guardar todo
        </button>
      </section>
    </div>
  </div>
</div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, Link, useForm } from '@inertiajs/vue3'
import SearchBar from '@/Components/SearchBar.vue'
import TableFloor from '@/Pages/Device/Components/TableFloor.vue'
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

const devices = ref([])             // [{ id, mac:'', floor:null }]
const nextId = ref(1)
const selectedDeviceId = ref(null)

const selectedDeviceIndex = computed(() =>
  devices.value.findIndex(d => d.id === selectedDeviceId.value)
)
const selectedDevice = computed(() =>
  selectedDeviceIndex.value !== -1 ? devices.value[selectedDeviceIndex.value] : null
)

/*****************************************************************
 * 𝗔𝗖𝗖𝗜𝗢𝗡𝗘𝗦 𝗜𝗭𝗤𝗨𝗜𝗘𝗥𝗗𝗔
 *****************************************************************/
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

  // Si ya no hay dispositivos, reinicia el contador a 1
  if (devices.value.length === 0) nextId.value = 1
}

const selectDevice = (id) => {
  selectedDeviceId.value = id
}

/*****************************************************************
 * 𝗩𝗔𝗟𝗜𝗗𝗔𝗖𝗜𝗢́𝗡 𝗠𝗔𝗖
 *****************************************************************/
const deviceErrors = ref({})   // { index: 'error message' }

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

/*****************************************************************
 * 𝗚𝗨𝗔𝗥𝗗𝗔𝗥 𝗧𝗢𝗗𝗢
 *****************************************************************/
const canSave = computed(() =>
  devices.value.length > 0 &&
  devices.value.every(d =>
    d.mac &&
    d.floor &&
    d.water_frequency &&
    d.sunlight
  )
)

const submitAll = async () => {
  if (!canSave.value) return

  const payload = devices.value.map(d => ({
    mac: d.mac,
    planta_id: d.floor.id,
    water_frequency: d.water_frequency,
    sunlight: d.sunlight
  }))

  try {
    await axios.post('/dispositivos', { devices: payload })
    // feedback / redirect …
  } catch (e) {
    console.error(e)
  }
}
</script>
