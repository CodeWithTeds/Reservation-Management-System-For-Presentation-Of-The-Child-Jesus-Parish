<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { urlIsActive } from '@/lib/utils';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronsUpDown } from 'lucide-vue-next';

defineProps<{
    items: NavItem[];
}>();

const page = usePage();
const notificationCount = (page.props.notificationCount as number) || 0;
const isClient = (page.props.auth?.user?.role === 'client');
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <!-- Regular menu item without dropdown -->
                <SidebarMenuButton v-if="!item.hasDropdown" as-child :is-active="urlIsActive(item.href, page.url)"
                    :tooltip="item.title">
                    <Link :href="item.href" class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <component :is="item.icon" class="mr-2 h-5 w-5" />
                            <span>{{ item.title }}</span>
                        </div>
                        <span v-if="item.title === 'Notifications' && isClient && notificationCount > 0"
                              class="ml-2 inline-flex items-center rounded-full bg-red-600 px-2 py-0.5 text-xs font-semibold text-white">
                            {{ notificationCount }}
                        </span>
                    </Link>
                </SidebarMenuButton>

                <!-- Menu item with dropdown -->
                <DropdownMenu v-else>
                    <DropdownMenuTrigger as-child>
                        <SidebarMenuButton
                            class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                            <component :is="item.icon" class="h-5 w-5" />
                            <span>{{ item.title }}</span>
                            <ChevronsUpDown class="ml-auto size-4" />
                        </SidebarMenuButton>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="min-w-48 rounded-lg" side="right" align="start" :side-offset="4">
                        <DropdownMenuItem v-for="dropdownItem in item.dropdownItems" :key="dropdownItem.title"
                            :as-child="true">
                            <Link class="block w-full" :href="dropdownItem.href">
                            <component v-if="dropdownItem.icon" :is="dropdownItem.icon" class="mr-2 h-4 w-4" />
                            {{ dropdownItem.title }}
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
