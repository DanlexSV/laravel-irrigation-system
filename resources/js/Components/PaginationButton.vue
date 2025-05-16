<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  link: { type: Object, required: true }
})

const emit = defineEmits(['paginate'])
const handleClick = () => props.link.url && emit('paginate', props.link.url)
</script>

<template>
  <button
    :disabled="!link.url"
    @click="handleClick"
    class="px-3 py-1 text-sm border rounded"
    :class="[
      link.active
        ? 'bg-brand text-white'
	: 'bg-white hover:bg-brand-light hover:text-brand',
      !link.url ? 'cursor-default opacity-60' : 'cursor-pointer'
    ]"
    v-html="link.label"
  />
</template>
