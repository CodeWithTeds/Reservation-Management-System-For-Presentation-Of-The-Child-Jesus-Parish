<script setup lang="ts">
import { inject, Ref, onMounted, onUnmounted } from 'vue';

const select = inject('select') as {
  open: Ref<boolean>;
};

// Close dropdown when clicking outside (robust to Text/SVG nodes)
const handleClickOutside = (event: MouseEvent) => {
  const path = (event.composedPath ? event.composedPath() : []) as Array<EventTarget>;
  const isInsideContent = path.some((el: any) => (el as Element)?.classList?.contains?.('select-content'));
  const isInsideTrigger = path.some((el: any) => (el as Element)?.getAttribute?.('data-select-trigger') === 'true');

  if (!isInsideContent && !isInsideTrigger) {
    select.open.value = false;
  }
};

// Ensure dropdown closes when ESC key is pressed
const handleKeyDown = (event: KeyboardEvent) => {
  if (event.key === 'Escape' && select.open.value) {
    select.open.value = false;
  }
};

onMounted(() => {
  document.addEventListener('mousedown', handleClickOutside);
  document.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside);
  document.removeEventListener('keydown', handleKeyDown);
});
</script>

<template>
  <div v-if="select.open" class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm select-content">
    <slot></slot>
  </div>
</template>