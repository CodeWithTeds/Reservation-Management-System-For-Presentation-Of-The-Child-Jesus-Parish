<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { route } from 'ziggy-js';

interface Room {
  id: number;
  name: string;
  description: string | null;
  capacity: number | null;
  status: string;
}

defineProps<{
  room: Room;
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
    <Head :title="`Room: ${room.name}`" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-2xl font-semibold text-gray-800">Room Details</h2>
              <div class="flex space-x-2">
                <Link :href="route('rooms.edit', room.id)">
                  <Button variant="outline">Edit Room</Button>
                </Link>
                <Link :href="route('rooms.index')">
                  <Button variant="secondary">Back to Rooms</Button>
                </Link>
              </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg mb-6">
              <div class="grid grid-cols-1 gap-6">
                <div>
                  <h3 class="text-lg font-medium text-gray-900">{{ room.name }}</h3>
                  <p v-if="room.description" class="mt-2 text-gray-600">{{ room.description }}</p>
                  <p v-if="room.capacity" class="mt-2 text-gray-600">
                    <span class="font-medium">Capacity:</span> {{ room.capacity }} people
                  </p>
                  <div class="mt-4">
                    <span class="text-sm font-medium text-gray-500">Status:</span>
                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                      :class="getStatusClass(room.status)">
                      {{ room.status }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>