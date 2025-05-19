<script setup>
import { computed } from 'vue'
import { Doughnut } from 'vue-chartjs'
import { Chart, ArcElement, Tooltip, Legend } from 'chart.js'
Chart.register(ArcElement, Tooltip, Legend)

const props = defineProps({
  label: String,
  humidity: Number
})

const chartData = computed(() => ({
  labels: ['Humedad', 'Falta'],
  datasets: [
    {
      data: [props.humidity, 100 - props.humidity],
      backgroundColor: ['#43a047', '#E8F5E9'],
      borderWidth: 0
    }
  ]
}))

const options = {
  cutout: '60%',
  plugins: { legend: { display: false }, tooltip: { enabled: false } }
}
</script>

<template>
  <div class="flex flex-col items-center gap-2">
    <div class="relative">
      <Doughnut :data="chartData" :options="options" class="w-36 h-36" />

      <div class="absolute inset-0 flex items-center justify-center">
        <span class="font-semibold text-brand-dark text-lg">
          {{ humidity }} %
        </span>
      </div>
    </div>

    <span class="mt-1 text-sm whitespace-pre-line text-center">
      {{ label }}
    </span>
  </div>
</template>
