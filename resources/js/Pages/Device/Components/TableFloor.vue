<script setup>
import { defineProps, defineEmits } from 'vue'
import PaginationButton from '@/Components/PaginationButton.vue'

const props = defineProps({
  floors:   { type: Object, required: true },
  selected: { type: Object, default: null }
})

const emit = defineEmits(['select', 'paginate'])

const selectFloor  = floor => emit('select', floor)
const changePage   = url   => url && emit('paginate', url)
</script>

<template>
  <div>
    <!-- Tabla de plantas -->
    <div class="overflow-y-auto max-h-80">
      <table class="w-full text-sm">
        <thead class="bg-gray-100 sticky top-0">
          <tr>
            <th class="text-left p-2">Nombre</th>
            <th class="text-left p-2">Nombre científico</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="floor in floors.data"
            :key="floor.id"
            @click="selectFloor(floor)"
            :class="[
              'cursor-pointer hover:bg-gray-50',
              selected?.id === floor.id ? 'bg-indigo-50' : ''
            ]"
          >
            <td class="p-2">{{ floor.name }}</td>
            <td class="p-2 italic text-gray-600">{{ floor.scientific_name }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- paginación -->
    <div class="mt-4 flex justify-center flex-wrap gap-2">
      <PaginationButton
        v-for="link in floors.links"
	:key="link.label"
	:link="link"
	@paginate="changePage"
      />
    </div>
  </div>
</template>
