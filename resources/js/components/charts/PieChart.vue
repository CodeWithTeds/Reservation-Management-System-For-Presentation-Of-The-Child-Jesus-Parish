<script setup lang="ts">
import { Pie } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
  type ChartData,
  type ChartOptions,
} from 'chart.js';
import { computed } from 'vue';

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);

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

const chartOptions = computed<ChartOptions<'pie'>>(() => ({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'right',
      labels: {
        boxWidth: 15,
        font: {
          size: 12,
        },
      },
    },
    title: {
      display: !!props.chartTitle,
      text: props.chartTitle || '',
    },
  },
}));

const chartDataset = computed<ChartData<'pie'>>(() => ({
  labels: props.chartData.labels,
  datasets: [
    {
      data: props.chartData.data,
      backgroundColor:
        props.bgColor || [
          'rgba(75, 192, 192, 0.6)',
          'rgba(54, 162, 235, 0.6)',
          'rgba(153, 102, 255, 0.6)',
          'rgba(255, 159, 64, 0.6)',
          'rgba(255, 99, 132, 0.6)',
          'rgba(255, 206, 86, 0.6)',
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
    },
  ],
}));
</script>

<template>
  <div :class="['chart-container', $attrs.class]">
    <Pie
      :data="chartDataset"
      :options="chartOptions"
      :chart-id="chartId || 'pie-chart'"
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