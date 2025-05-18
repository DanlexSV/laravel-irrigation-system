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
      backgroundColor: [
        '#43a047',
        '#E8F5E9'
      ],
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
    <Doughnut :data="chartData" :options="options" class="w-40 h-40" />

    <!-- Valor numérico dentro de la dona -->
    <div class="absolute flex items-center justify-center w-40 h-80">
      <span class="font-semibold text-brand-dark text-lg">
        Humedad: {{ humidity }} %
      </span>
    </div>

    <span class="text-sm mt-1">{{ label }}</span>
  </div>
</template>

<style scoped>
div.relative {
  position: relative;
}
</style>
