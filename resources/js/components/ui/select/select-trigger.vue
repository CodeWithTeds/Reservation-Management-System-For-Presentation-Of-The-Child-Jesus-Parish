<script setup lang="ts">
import { inject, Ref, ref, onMounted, onBeforeUnmount, nextTick } from 'vue';

const props = defineProps<{
  class?: string;
}>();

const select = inject('select') as {
  open: Ref<boolean>;
  selectedValue: Ref<string>;
  setTriggerEl: (el: HTMLElement | null) => void;
  updatePosition: () => void;
};

const triggerRef = ref<HTMLElement | null>(null);

const toggleOpen = async (event: MouseEvent) => {
  event.stopPropagation();
  select.open.value = !select.open.value;
  if (select.open.value) {
    await nextTick();
    select.updatePosition();
  }
};

onMounted(() => {
  select.setTriggerEl(triggerRef.value);
});

onBeforeUnmount(() => {
  select.setTriggerEl(null);
});
</script>

<template>
  <button
    ref="triggerRef"
    type="button"
    @click="toggleOpen($event)"
    data-select-trigger="true"
    :class="[
      'flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
      props.class
    ]"
  >
    <slot></slot>
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="24"
      height="24"
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
      class="h-4 w-4 opacity-50"
      :class="{ 'rotate-180': select.open }"
    >
      <polyline points="6 9 12 15 18 9"></polyline>
    </svg>
  </button>
</template>