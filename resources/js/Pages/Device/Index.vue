<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const { props } = usePage()
const devices = props.devices

const successMessage = props.flash?.success ?? null
const showSuccess    = ref(!!successMessage)

onMounted(() => {
  if (showSuccess.value) {
    setTimeout(() => (showSuccess.value = false), 10_000)
  }
})
</script>

<template>
  <Head title="Dispositivos Vinculados" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
	Dispositivos Vinculados
      </h2>
    </template>

    <div
      v-if="showSuccess"
      class="mx-auto max-w-5xl px-6 pt-6"
    >
      <div class="bg-green-100 text-green-800 p-4 rounded-xl">
    	{{ successMessage }}
      </div>
    </div>

    <div class="py-6">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">

          <div class="flex justify-between items-center mb-6">
            <p class="text-lg font-medium">¿Quieres agregar un nuevo dispositivo?</p>
            <button
	      class="bg-brand hover:bg-brand-dark text-white px-4 py-2 rounded shadow"
	      @click="() => router.visit(route('device.new'))"
            >
              Agregar
            </button>
          </div>

	  <div v-if="devices.length > 0">
	    <table class="min-w-full border border-brand rounded-md">
	      <thead class="bg-brand-darker text-white">
		<tr>
		  <th class="text-left p-3 border-b border-brand-dark/30">MAC Address</th>
		  <th class="text-left p-3 border-b border-brand-dark/30">Planta</th>
		  <th class="text-left p-3 border-b border-brand-dark/30">Riego (días)</th>
		  <th class="text-left p-3 border-b border-brand-dark/30">Luz solar</th>
		  <th class="text-left p-3 border-b border-brand-dark/30">Fecha de registro</th>
		</tr>
	      </thead>
	      <tbody>
		<tr
		  v-for="device in devices"
		  :key="device.id"
		  class="hover:bg-brand-light"
		>
		  <td class="p-3 border-b border-brand/10">{{ device.mac_address }}</td>
		  <td class="p-3 border-b border-brand/10">
		    {{ device.floor ? device.floor.name : '—' }}
		  </td>
		  <td class="p-3 border-b border-brand/10">
		    {{ device.water_frequency ?? '—' }}
		  </td>
		  <td class="p-3 border-b border-brand/10">
		    {{ device.sunlight ?? '—' }}
		  </td>
		  <td class="p-3 border-b border-brand/10">
		    {{ new Date(device.created_at).toLocaleString() }}
		  </td>
		</tr>
	      </tbody>
	    </table>
	  </div>

          <div v-else class="text-gray-600 mt-4">
            Aún no tienes dispositivos registrados.
          </div>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
