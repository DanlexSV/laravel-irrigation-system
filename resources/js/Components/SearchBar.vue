<script setup>
import { ref, watch } from 'vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faSearch } from '@fortawesome/free-solid-svg-icons'
import { debounce } from 'lodash-es'

library.add(faSearch)

const props = defineProps({
  modelValue: { type: String, default: '' },
  placeholder: { type: String, default: 'Buscar...' },
})

const emit = defineEmits(['update:modelValue', 'search'])

const query = ref(props.modelValue)

watch(
  () => props.modelValue,
  (val) => {
    if (val !== query.value) query.value = val
  }
)

const debouncedSearch = debounce(() => {
  emit('update:modelValue', query.value)
  emit('search', query.value)
}, 400)

watch(query, () => {
  debouncedSearch()
})
</script>

<template>
  <div class="flex w-full mb-4">
    <input
      v-model="query"
      :placeholder="placeholder"
      class="flex-1 rounded-l-full border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
    />

    <button
      type="button"
      @click="() => emit('search', query)"
      class="rounded-r-full border border-l-0 bg-gray-200 px-4 hover:bg-gray-300 flex items-center justify-center"
      :title="placeholder"
    >
      <FontAwesomeIcon icon="search" />
    </button>
  </div>
</template>
