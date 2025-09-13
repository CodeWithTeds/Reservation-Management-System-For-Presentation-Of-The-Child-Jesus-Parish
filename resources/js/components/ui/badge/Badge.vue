<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

interface Props {
  variant?: 'default' | 'secondary' | 'destructive' | 'outline' | 'success' | 'warning' | 'pending'
  class?: HTMLAttributes['class']
}

const props = withDefaults(defineProps<Props>(), {
  variant: 'default',
})
</script>

<template>
  <div
    data-slot="badge"
    :class="cn(
      'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2',
      {
        'bg-primary text-primary-foreground hover:bg-primary/80 border-transparent':
          props.variant === 'default',
        'bg-secondary text-secondary-foreground hover:bg-secondary/80 border-transparent':
          props.variant === 'secondary',
        'bg-destructive text-destructive-foreground hover:bg-destructive/80 border-transparent':
          props.variant === 'destructive',
        'text-foreground border-border hover:bg-accent hover:text-accent-foreground':
          props.variant === 'outline',
        'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800':
          props.variant === 'success',
        'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800':
          props.variant === 'warning',
        'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800':
          props.variant === 'pending',
      },
      props.class,
    )"
  >
    <slot />
  </div>
</template>