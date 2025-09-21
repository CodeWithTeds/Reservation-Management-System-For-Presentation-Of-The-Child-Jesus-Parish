<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-dvh items-center justify-center bg-[#F7F7F7] p-6">
        <div class="grid w-full max-w-4xl overflow-hidden rounded-xl bg-white shadow-lg lg:grid-cols-2">
            <div class="flex items-center justify-center p-10">
                <div class="mx-auto w-full max-w-md">
                    <div class="mb-6 grid gap-2 text-center">
                        <Link :href="home()" class="flex justify-center">
                            <AppLogoIcon class="h-14 w-14" />
                        </Link>
                        <h1 v-if="title" class="text-2xl font-bold">
                            {{ title }}
                        </h1>
                        <p v-if="description" class="text-balance text-muted-foreground">
                            {{ description }}
                        </p>
                    </div>
                    <slot />
                </div>
            </div>
            <div
                class="hidden bg-muted lg:block h-full bg-cover bg-center"
                style="background-image: url('/images/g.png');"
            >
            </div>
        </div>
    </div>
</template>
