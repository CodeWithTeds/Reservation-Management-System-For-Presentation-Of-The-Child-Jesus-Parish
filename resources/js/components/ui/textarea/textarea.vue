<script setup lang="ts">
import { computed } from 'vue';

defineOptions({ inheritAttrs: false });

const props = defineProps<{
  modelValue?: string | null;
  placeholder?: string;
  rows?: number;
  disabled?: boolean;
  error?: string;
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void;
}>();

const model = computed<string>({
  get: () => props.modelValue ?? '',
  set: (val: string) => emit('update:modelValue', val ?? ''),
});
</script>

<template>
  <div class="w-full">
    <textarea
      v-model="model"
      :class="[
        'flex min-h-[80px] w-full rounded-md border bg-white px-3 py-2 text-sm ring-offset-background placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
        error ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-indigo-500',
        // forward incoming classes to the textarea element
        $attrs.class as string | undefined
      ]"
      :placeholder="placeholder"
      :rows="rows || 3"
      :disabled="disabled"
      :aria-invalid="!!error"
      :aria-errormessage="error ? 'error-message' : undefined"
      v-bind="{ ...$attrs, class: undefined }"
    ></textarea>
    <p v-if="error" id="error-message" class="mt-1 text-sm text-red-500">{{ error }}</p>
  </div>
</template>