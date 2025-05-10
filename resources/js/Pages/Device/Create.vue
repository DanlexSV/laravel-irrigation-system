<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

// FontAwesome
import { library } from '@fortawesome/fontawesome-svg-core';
import { faTrash, faPlus } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faTrash, faPlus);

const macAddresses = ref([{ value: '' }]);
const errors = ref([]);

const addMacField = () => {
  macAddresses.value.push({ value: '' });
};

const removeMacField = (index) => {
  macAddresses.value.splice(index, 1);
  errors.value.splice(index, 1);
};

const isValidMac = (mac) => {
  return /^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/.test(mac);
};

const formatMacInput = (index) => {
  let raw = macAddresses.value[index].value;

  raw = raw.replace(/[^0-9A-Fa-f:]/g, '');

  let cleaned = raw.replace(/:/g, '').toUpperCase();

  let formatted = '';
  for (let i = 0; i < cleaned.length && i < 12; i += 2) {
    if (i > 0) formatted += ':';
    formatted += cleaned.substr(i, 2);
  }

  macAddresses.value[index].value = formatted;
};

const submit = () => {
  errors.value = [];
  const payload = macAddresses.value.map((m) => m.value.trim());
  const seen = new Set();

  payload.forEach((mac, index) => {
    if (!mac) {
      errors.value[index] = 'Este campo es obligatorio.';
    } else if (!isValidMac(mac)) {
      errors.value[index] = 'Formato inválido. Usa XX:XX:XX:XX:XX:XX';
    } else if (seen.has(mac)) {
      errors.value[index] = 'Este valor ya está duplicado.';
    } else {
      errors.value[index] = null;
      seen.add(mac);
    }
  });

  if (errors.value.some((e) => e !== null)) return;

  router.post(
    route('device.store'),
    { mac_addresses: payload },
    {
      onError: (serverErrors) => {
        errors.value = [];

        if (serverErrors['mac_addresses']) {
          serverErrors['mac_addresses'].forEach((msg, index) => {
            errors.value[index] = msg;
          });
        }

        for (const key in serverErrors) {
          if (key.startsWith('mac_addresses.') && /^[0-9]+$/.test(key.split('.')[1])) {
            const idx = parseInt(key.split('.')[1]);
            errors.value[idx] = serverErrors[key];
          }
        }
      },
    }
  );
};
</script>

<template>
  <Head title="Nuevo Dispositivo" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Vincular Dispositivo
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
          <form @submit.prevent="submit">
            <div class="space-y-4">
              <div
                v-for="(entry, index) in macAddresses"
                :key="index"
		class="flex flex-col gap-1"
              >
	        <div class="flex items-center gap-2">
                  <input
                    v-model="entry.value"
		    @input="formatMacInput(index)"
		    type="text"
		    class="flex-1 border border-gray-300 rounded px-3 py-2"
		    placeholder="00:1A:2B:3C:4D:5E"
		  />
                  <button
		    v-if="macAddresses.length > 1"
		    type="button"
		    @click="removeMacField(index)"
		    class="text-red-600 hover:text-red-800"
		    title="Eliminar"
                  >
                    <FontAwesomeIcon icon="trash" />
                  </button>
                </div>
		
		  <span v-if="errors[index]" class="text-red-600 text-sm block ml-1">
		    {{ errors[index] }}
                  </span>
              </div>

              <button
                type="button"
                @click="addMacField"
                class="text-blue-600 hover:underline flex items-center gap-1 mt-2"
              >
                <FontAwesomeIcon icon="plus" />
                Añadir otro dispositivo
              </button>
            </div>

            <div class="mt-6">
              <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
              >
                Guardar dispositivos
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
