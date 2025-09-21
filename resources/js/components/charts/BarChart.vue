<script setup lang="ts">
import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  type ChartData,
  type ChartOptions,
} from 'chart.js';
import { computed } from 'vue';

// Register ChartJS components
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const props = defineProps<{
  chartData: {
    labels: string[];
    data: number[];
  };
  chartTitle?: string;
  chartId?: string;
  width?: number;
  height?: number;
  bgColor?: string[];
  borderColor?: string[];
}>();

const chartOptions = computed<ChartOptions<'bar'>>(() => ({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false,
    },
    title: {
      display: !!props.chartTitle,
      text: props.chartTitle || '',
    },
  },
  scales: {
    y: {
      beginAtZero: true,
      grid: {
        display: true,
        color: 'rgba(0, 0, 0, 0.1)',
      },
      ticks: {
        precision: 0,
      },
    },
    x: {
      grid: {
        display: false,
      },
    },
  },
}));

const chartDataset = computed<ChartData<'bar'>>(() => ({
  labels: props.chartData.labels,
  datasets: [
    {
      label: 'Count',
      data: props.chartData.data,
      backgroundColor:
        props.bgColor || [
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 99, 132, 0.2)',
          'rgba(255, 206, 86, 0.2)',
        ],
      borderColor:
        props.borderColor || [
          'rgba(75, 192, 192, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(255, 99, 132, 1)',
          'rgba(255, 206, 86, 1)',
        ],
      borderWidth: 1,
      borderRadius: 6,
    },
  ],
}));
</script>

<template>
  <div :class="['chart-container', $attrs.class]">
    <Bar
      :data="chartDataset"
      :options="chartOptions"
      :chart-id="chartId || 'bar-chart'"
      :width="width || 400"
      :height="height || 200"
    />
  </div>
</template>

<style scoped>
.chart-container {
  position: relative;
  width: 100%;
  height: 100%;
}
</style>