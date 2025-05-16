<script setup>
import { defineProps, defineEmits } from 'vue'
import SearchBar   from '@/Components/SearchBar.vue'
import TableFloor  from '@/Pages/Device/Components/TableFloor.vue'

const props = defineProps({
  selectedDevice:      { type: Object, default: null },
  selectedIndex:       { type: Number, default: -1 },
  floors:              { type: Object, required: true },
  search:              { type: String, required: true },
  canSave:             { type: Boolean, required: true },
  deviceErrors:        { type: Object, required: true },
  isLoading:           { type: Boolean, default: false },
})

const emit = defineEmits([
  'update:search',
  'search',
  'paginate',
  'select-plant',
  'format-mac',
  'save',
])
</script>

<template>
  <section class="bg-white p-6 rounded-xl shadow-sm lg:col-span-2 flex flex-col gap-6">

    <!-- ======= CUANDO HAY DISPOSITIVO SELECCIONADO ======= -->
    <template v-if="selectedDevice">
      <!-- 1. Selección de planta -->
      <h3 class="font-semibold mb-4">Selecciona una planta</h3>

      <SearchBar
        :model-value="search"
        placeholder="Buscar planta..."
        @update:model-value="$emit('update:search', $event)"
        @search="$emit('search')"
      />

      <TableFloor
        :floors="floors"
        :selected="selectedDevice.floor"
        @select="plant => $emit('select-plant', plant)"
        @paginate="url => $emit('paginate', url)"
      />

      <!-- 2. Campos adicionales -->
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

      <!-- 3. MAC -->
      <div class="mt-6">
        <label class="block text-sm mb-1 font-semibold">Dirección MAC</label>
        <input
          v-model="selectedDevice.mac"
          @input="$emit('format-mac', selectedIndex)"
          type="text"
          placeholder="00:1A:2B:3C:4D:5E"
          class="w-full rounded px-3 py-2 border"
          :class="deviceErrors[selectedIndex] ? 'border-red-500' : 'border-gray-300'"
        />
        <span
          v-if="deviceErrors[selectedIndex]"
          class="text-red-600 text-sm"
        >
          {{ deviceErrors[selectedIndex] }}
        </span>
      </div>
    </template>

    <!-- ======= MENSAJE POR DEFECTO ======= -->
    <template v-else>
      <p class="text-gray-500 italic flex-1 flex items-center justify-center">
        No hay ningún dispositivo seleccionado
      </p>
    </template>

    <!-- ======= GUARDAR TODO ======= -->
    <button
      type="button"
      @click="$emit('save')"
      :disabled="!canSave"
      class="self-end bg-brand-dark text-white px-6 py-2 rounded-2xl
             disabled:opacity-60 disabled:cursor-not-allowed"
    >
      Guardar todo
    </button>
  </section>
</template>
