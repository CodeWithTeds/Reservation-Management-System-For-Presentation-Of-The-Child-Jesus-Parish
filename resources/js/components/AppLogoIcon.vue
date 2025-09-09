<script setup lang="ts">
import type { HTMLAttributes } from 'vue'

defineOptions({
    inheritAttrs: false,
})

interface Props {
    className?: HTMLAttributes['class']
}

defineProps<Props>()
</script>

<template>
    <img
        src="/images/logo.png"
        alt="Logo"
        class="h-18 w-25 rounded-full"
        v-bind="$attrs"
    />
</template>
