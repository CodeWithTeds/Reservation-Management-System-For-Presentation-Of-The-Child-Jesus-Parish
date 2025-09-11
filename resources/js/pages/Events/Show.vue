<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { format } from 'date-fns';

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

const props = defineProps<{
  event: Event;
}>();

const formatDateTime = (dateTime: string): string => {
  return format(new Date(dateTime), 'MMM d, yyyy h:mm a').replace('yyyy', new Date(dateTime).getFullYear().toString());
};

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

const confirmDelete = (): boolean => confirm('Are you sure you want to delete this event?');
</script>

<template>
  <AppLayout>
    <Head :title="`Event: ${event.title}`" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
              <h1 class="text-2xl font-semibold text-gray-900">Event Details</h1>
              <div class="flex space-x-4">
                <Link :href="`/events/${event.id}/edit`">
                  <Button>Edit Event</Button>
                </Link>
                <Link href="/events">
                  <Button variant="outline">Back to Events</Button>
                </Link>
              </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <h2 class="text-xl font-semibold mb-4">{{ event.title }}</h2>
                  
                  <div class="mb-4">
                    <span
                      class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full"
                      :class="getStatusClass(event.status)"
                    >
                      {{ event.status }}
                    </span>
                  </div>

                  <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Event Type</p>
                    <p class="text-gray-900">{{ event.event_type }}</p>
                  </div>

                  <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Location</p>
                    <p class="text-gray-900">{{ event.location }}</p>
                  </div>

                  <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Priest Name</p>
                    <p class="text-gray-900">{{ event.priest_name || 'Not specified' }}</p>
                  </div>

                  <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Created By</p>
                    <p class="text-gray-900">{{ event.creator.name }}</p>
                  </div>
                </div>

                <div>
                  <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Start Time</p>
                    <p class="text-gray-900">{{ formatDateTime(event.start_time) }}</p>
                  </div>

                  <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">End Time</p>
                    <p class="text-gray-900">{{ formatDateTime(event.end_time) }}</p>
                  </div>

                  <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Created At</p>
                    <p class="text-gray-900">{{ formatDateTime(event.created_at) }}</p>
                  </div>

                  <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Last Updated</p>
                    <p class="text-gray-900">{{ formatDateTime(event.updated_at) }}</p>
                  </div>
                </div>
              </div>

              <div class="mt-6">
                <p class="text-sm text-gray-600 mb-1">Description</p>
                <p class="text-gray-900 whitespace-pre-line">{{ event.description || 'No description provided.' }}</p>
              </div>

              <div class="mt-6">
                <p class="text-sm text-gray-600 mb-1">Activities</p>
                <p class="text-gray-900 whitespace-pre-line">{{ event.activities || 'No activities specified.' }}</p>
              </div>

              <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-end">
                  <Button
                    variant="destructive"
                    @click="
                      router.delete(`/events/${event.id}`, {
                        onBefore: () => confirmDelete(),
                      })
                    "
                  >
                    Delete Event
                  </Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>