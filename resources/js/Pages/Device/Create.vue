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
        <section class="bg-white p-6 rounded shadow-sm">
          <h3 class="font-semibold mb-4">Selecciona una planta</h3>

          <!-- buscador -->
	  <SearchBar
	    v-model="search"
	    placeholder="Buscar planta..."
	    @search="doSearch"
	  />

          <!-- tabla paginada -->
	  <TableFloor
	    :floors="floors"
	    :selected="selectedFloor"
	    @select="selectFloor"
	    @paginate="changePage"
	  />
        </section>
	<section class="bg-white p-6 rounded shadow-sm">
          <form @submit.prevent="submit" class="space-y-6">

            <!-- if a planta is selected show editable fields -->
            <div v-if="selectedFloor" class="space-y-4">
              <h3 class="font-semibold">Planta seleccionada</h3>

              <div class="border p-3 rounded bg-gray-50">
                <p class="font-medium">{{ selectedFloor.name }}</p>
                <p class="italic text-gray-600">{{ selectedFloor.scientific_name }}</p>
              </div>

              <div class="flex gap-4">
                <div class="flex-1">
                  <label class="block text-sm mb-1">Frecuencia de riego (días)</label>
                  <input
                    v-model.number="selectedFloor.water_frequency"
                    type="number"
                    min="1"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                  />
                </div>

                <div class="flex-1">
                  <label class="block text-sm mb-1">Luz solar</label>
                  <input
                    v-model="selectedFloor.sunlight"
                    type="text"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                  />
                </div>
              </div>
            </div>

            <div class="space-y-4">
              <h3 class="font-semibold">Direcciones MAC</h3>

              <div
                v-for="(entry, idx) in macAddresses"
                :key="idx"
                class="flex flex-col gap-1"
              >
                <div class="flex items-center gap-2">
                  <input
                    v-model="entry.value"
                    @input="formatMacInput(idx)"
                    type="text"
                    placeholder="00:1A:2B:3C:4D:5E"
                    class="flex-1 rounded px-3 py-2"
                    :class="errors[idx] ? 'border-red-500' : 'border-gray-300'"
                  />
                  <button
                    v-if="macAddresses.length > 1"
                    type="button"
                    @click="removeMacField(idx)"
                    class="text-red-600 hover:text-red-800"
                    title="Eliminar"
                  >
                    <FontAwesomeIcon icon="trash" />
                  </button>
                </div>
                <span v-if="errors[idx]" class="text-red-600 text-sm ml-1">{{ errors[idx] }}</span>
              </div>

              <button
                type="button"
                @click="addMacField"
		class="text-brand hover:text-brand-dark hover:underline flex items-center gap-1"
              >
                <FontAwesomeIcon icon="plus" />
                Añadir otro dispositivo
              </button>
            </div>

            <button
              type="submit"
	      class="bg-brand hover:bg-brand-dark text-white px-6 py-2 rounded-2xl ml-auto block"
	    >
              Guardar dispositivos
            </button>
          </form>
        </section>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
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

const addMacField = () => {
  macAddresses.value.push({ value: '' })
}

const removeMacField = (index) => {
  macAddresses.value.splice(index, 1)
  delete errors.value[index]
}

const formatMacInput = (index) => {
  const val = macAddresses.value[index].value
  macAddresses.value[index].value = (
    val.replace(/[^a-fA-F0-9]/g, '')
       .toUpperCase()
       .match(/.{1,2}/g)?.join(':')
       .slice(0, 17)
  ) || ''
}
</script>
