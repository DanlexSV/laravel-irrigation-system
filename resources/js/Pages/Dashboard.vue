<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, usePage } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'
import DeviceHumidityDonut from '@/Components/DeviceHumidityDonut.vue'

const { props } = usePage()
const devices = ref(props.devices)

let intervalId
const fetchDevices = async () => {
  const res = await axios.get(route('dashboard.devices'))
  devices.value = res.data
}

onMounted(() => {
  intervalId = setInterval(fetchDevices, 7_000)
})

onUnmounted(() => clearInterval(intervalId))
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
    </template>

    <div class="py-6">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm rounded-xl p-6">
	  <div class="flex items-center justify-center mb-6">
	    <h2 class="text-xl font-semibold leading-tight text-brand-darker">Humedad en las Plantas</h2>
	  </div>
          <div v-if="devices.length" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <DeviceHumidityDonut
              v-for="d in devices"
              :key="d.id"
	      :label="`${d.floor?.name ?? 'Sin planta'}\n${d.mac_address}`"
              :humidity="d.last_humidity"
            />
          </div>

          <p v-else class="text-gray-600">No hay lecturas de humedad aún.</p>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
