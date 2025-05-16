<script setup>
import { defineProps, defineEmits } from 'vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const props = defineProps({
  devices:         { type: Array,  required: true },
  selectedId:      { type: Number, default: null   },
})

const emit = defineEmits(['add', 'select', 'remove'])

const add     = ()       => emit('add')
const select  = (id)     => emit('select', id)
const remove  = (id)     => emit('remove', id)
</script>

<template>
  <section class="bg-white p-6 rounded-xl shadow-sm flex flex-col gap-4">
    <!-- Agregar dispositivo -->
    <button
      type="button"
      @click="add"
      class="bg-brand hover:bg-brand-dark text-white px-4 py-2 rounded-xl text-sm"
    >
      Agregar dispositivo
    </button>

    <!-- Lista -->
    <div
      v-for="(device, idx) in devices"
      :key="device.id"
      class="flex items-center gap-2"
    >
      <button
        @click="select(device.id)"
        class="flex-1 text-left px-3 py-2 rounded border transition"
        :class="device.id === selectedId
          ? 'bg-brand-light text-brand border-brand'
          : 'bg-white hover:bg-gray-50 border-gray-200'"
      >
        Dispositivo {{ idx + 1 }}
      </button>

      <button
        @click="remove(device.id)"
        class="text-red-600 hover:text-red-800"
        title="Eliminar dispositivo"
      >
        <FontAwesomeIcon icon="trash" />
      </button>
    </div>
  </section>
</template>
