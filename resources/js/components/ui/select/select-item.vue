<script setup lang="ts">
import { inject, Ref, computed } from 'vue';

const props = defineProps<{
  value: string;
}>();

const select = inject('select') as {
  selectedValue: Ref<string>;
  updateValue: (value: string) => void;
};

const isSelected = computed(() => {
  return select.selectedValue.value === props.value;
});

const selectItem = (event: MouseEvent) => {
  event.stopPropagation();
  select.updateValue(props.value);
};
</script>

<template>
  <div
    @click="selectItem"
    :class="[
      'relative cursor-default select-none py-2 pl-10 pr-4',
      isSelected ? 'bg-indigo-100 text-indigo-900' : 'text-gray-900 hover:bg-gray-100'
    ]"
  >
    <span :class="['block truncate', isSelected ? 'font-medium' : 'font-normal']">      
      <slot></slot>
    </span>
    <span v-if="isSelected" class="absolute inset-y-0 left-0 flex items-center pl-3 text-indigo-600">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
    </span>
  </div>
</template>