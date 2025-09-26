<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItemType, AppPageProps } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage<AppPageProps>();
const flash = computed(() => page.props.flash || {});
const showFlash = ref(false);

watch(
    () => (flash.value as any).message,
    (msg) => {
        showFlash.value = !!msg;
        if (msg) {
            // Auto-hide after 5 seconds
            setTimeout(() => {
                showFlash.value = false;
            }, 5000);
        }
    },
    { immediate: true },
);
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent variant="sidebar" class="overflow-x-hidden overflow-y-auto">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />

            <!-- Flash message banner -->
            <div v-if="showFlash" class="mx-4 mb-4">
                <div
                    :class="[
                        'flex items-center justify-between rounded-lg p-3 text-sm shadow',
                        (flash as any).type === 'error' ? 'bg-red-600 text-white' : 'bg-green-600 text-white',
                    ]"
                >
                    <div class="flex items-center gap-2">
                        <svg v-if="(flash as any).type !== 'error'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12l2 2 4-4"></path>
                            <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0"></path>
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <span class="font-medium">{{ (flash as any).message }}</span>
                    </div>
                    <button type="button" class="rounded-md bg-black/10 px-2 py-1 text-white hover:bg-black/20" @click="showFlash = false">Close</button>
                </div>
            </div>

            <slot />
        </AppContent>
    </AppShell>
</template>
