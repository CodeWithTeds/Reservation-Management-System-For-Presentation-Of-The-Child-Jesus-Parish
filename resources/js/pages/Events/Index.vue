<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { format } from 'date-fns';
import { route } from 'ziggy-js';

// Function to confirm deletion
const confirmDelete = () => window.confirm('Are you sure you want to delete this event?');

interface Event {
  id: number;
  title: string;
  description: string | null;
  location: string;
  start_time: string;
  end_time: string;
  event_type: string;
  status: string;
  priest_name: string | null;
  activities: string | null;
  created_by: number;
  created_at: string;
  updated_at: string;
  creator: {
    id: number;
    name: string;
    email: string;
  };
}

defineProps<{
  events: Event[];
}>();

const getStatusClass = (status: string): string => {
    switch (status.toLowerCase()) {
        case 'scheduled':
            return 'bg-blue-100 text-blue-800';
        case 'cancelled':
            return 'bg-red-100 text-red-800';
        case 'completed':
            return 'bg-green-100 text-green-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const formatDateTime = (dateTime: string): string => {
    return format(new Date(dateTime), 'MMM d, yyyy h:mm a');
};
</script>

<template>
    <AppLayout>

        <Head title="Events" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-semibold text-gray-900">Events</h1>
                            <div class="flex space-x-4">
                                <Link :href="route('events.calendar')">
                                <Button variant="outline">Calendar View</Button>
                                </Link>
                                <Link :href="route('events.create')">
                                <Button>Add New Event</Button>
                                </Link>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Title
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Location
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Priest Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Start Time
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            End Time
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Created By
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="event in events" :key="event.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ event.title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ event.event_type }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ event.location }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ event.priest_name || 'Not specified' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ formatDateTime(event.start_time) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ formatDateTime(event.end_time) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                :class="getStatusClass(event.status)">
                                                {{ event.status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ event.creator.name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex space-x-2 justify-end">
                                                <Link :href="`/events/${event.id}`"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                View
                                                </Link>
                                                <Link :href="`/events/${event.id}/edit`"
                                                    class="text-blue-600 hover:text-blue-900">
                                                Edit
                                                </Link>
                                                <button type="button" class="text-red-600 hover:text-red-900"
                                                    @click="
                                                         router.delete(`/events/${event.id}`, {
                                                              onBefore: confirmDelete,
                                                          })
                                                          ">
                                                Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="events.length === 0">
                                        <td colspan="9" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            No events found.
                                            <Link :href="route('events.create')" class="text-indigo-600">Create one
                                            </Link>.
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