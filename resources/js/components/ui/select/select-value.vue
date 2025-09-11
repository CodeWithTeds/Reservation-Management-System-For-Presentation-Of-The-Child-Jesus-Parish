<script setup lang="ts">
import { inject, Ref, computed } from 'vue';

const props = defineProps<{
  placeholder?: string;
}>();

const select = inject('select') as {
  selectedValue: Ref<string>;
};

const displayValue = computed(() => {
  return select.selectedValue.value || props.placeholder || 'Select an option';
});
</script>

<template>
  <span class="block truncate">{{ displayValue }}</span>
</template>