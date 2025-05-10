<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  devices: Array,
});
</script>

<template>
  <Head title="Dispositivos Vinculados" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
	Dispositivos Vinculados
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">

          <div class="flex justify-between items-center mb-6">
            <p class="text-lg font-medium">¿Quieres agregar un nuevo dispositivo?</p>
            <button
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow"
	      @click="() => router.visit(route('device.new'))"
            >
              Agregar
            </button>
          </div>

          <div v-if="devices.length > 0">
            <table class="min-w-full border border-gray-300 rounded-md">
              <thead class="bg-gray-100">
                <tr>
                  <th class="text-left p-3 border-b">ID</th>
                  <th class="text-left p-3 border-b">MAC Address</th>
                  <th class="text-left p-3 border-b">Fecha de Registro</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="device in devices" :key="device.id" class="hover:bg-gray-50">
                  <td class="p-3 border-b">{{ device.id }}</td>
                  <td class="p-3 border-b">{{ device.mac_address }}</td>
                  <td class="p-3 border-b">{{ new Date(device.created_at).toLocaleString() }}</td>
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
