<script setup lang="ts">
import { provide, ref } from 'vue';

const props = defineProps<{
  modelValue?: string;
}>();

const emit = defineEmits<{
  'update:modelValue': [value: string];
}>();

// Always initialize as closed
const open = ref(false);
const selectedValue = ref(props.modelValue || '');

// Track trigger element and its viewport rect for Teleport positioning
const triggerEl = ref<HTMLElement | null>(null);
const triggerRect = ref<{ top: number; left: number; width: number; height: number }>({
  top: 0,
  left: 0,
  width: 0,
  height: 0,
});

const setTriggerEl = (el: HTMLElement | null) => {
  triggerEl.value = el;
};

const updatePosition = () => {
  if (triggerEl.value) {
    const r = triggerEl.value.getBoundingClientRect();
    // Use viewport coordinates for fixed-positioned dropdown
    triggerRect.value = { top: r.top, left: r.left, width: r.width, height: r.height };
  }
};

// Force close dropdown on initialization
open.value = false;

provide('select', {
  open,
  selectedValue,
  triggerRect,
  setTriggerEl,
  updatePosition,
  updateValue: (value: string) => {
    selectedValue.value = value;
    emit('update:modelValue', value);
    // Ensure dropdown closes after selection
    open.value = false;
  }
});
</script>

<template>
  <div class="relative">
    <slot></slot>
  </div>
</template> 