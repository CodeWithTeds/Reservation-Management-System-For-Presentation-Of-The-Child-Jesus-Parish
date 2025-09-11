<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { route } from 'ziggy-js';

// Function to confirm deletion
const confirmDelete = () => window.confirm('Are you sure you want to delete this room?');

interface Room {
    id: number;
    name: string;
    description: string | null;
    capacity: number | null;
    status: string;
}

defineProps<{
    rooms: Room[];
}>();

const getStatusClass = (status: string): string => {
    switch (status.toLowerCase()) {
        case 'available':
            return 'bg-green-100 text-green-800';
        case 'occupied':
            return 'bg-red-100 text-red-800';
        case 'maintenance':
            return 'bg-yellow-100 text-yellow-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};
</script>

<template>
    <AppLayout>
        <Head title="Rooms" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-semibold text-gray-800">Room Management</h2>
                            <Link :href="route('rooms.create')">
                                <Button>Add New Room</Button>
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Capacity
                                        </th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr v-for="room in rooms" :key="room.id">
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ room.name }}</div>
                                            <div v-if="room.description" class="text-sm text-gray-500 truncate max-w-xs">
                                                {{ room.description }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ room.capacity || 'N/A' }}</div>
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                :class="getStatusClass(room.status)">
                                                {{ room.status }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <Link :href="route('rooms.edit', room.id)"
                                                    class="text-blue-600 hover:text-blue-900">Edit</Link>
                                                <Link :href="route('rooms.destroy', room.id)" method="delete"
                                                    as="button" type="button" @click="confirmDelete"
                                                    class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </Link>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="rooms.length === 0">
                                        <td colspan="4" class="py-4 px-4 text-center text-gray-500">
                                            No rooms found.
                                            <Link :href="route('rooms.create')"
                                                class="text-indigo-600 hover:text-indigo-900">Create one</Link>.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>