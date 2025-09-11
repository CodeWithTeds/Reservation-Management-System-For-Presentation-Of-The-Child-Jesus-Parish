<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import Textarea from '@/components/ui/textarea/textarea.vue';
// Select components removed as we're using standard HTML select elements

import InputError from '@/components/InputError.vue';

interface Room {
  id: number;
  name: string;
  capacity: number | null;
  status: string;
}

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
  room_id: number | null;
}

interface EventForm {
  title: string;
  description: string | null;
  location: string;
  start_time: string;
  end_time: string;
  event_type: string;
  status: string;
  priest_name: string | null;
  activities: string | null;
  room_id: number | null;
  _method: string;
}

const props = defineProps<{
  event: Event;
  rooms: Room[];
}>();

const form = useForm<EventForm>({
  title: props.event.title,
  description: props.event.description || '',
  location: props.event.location,
  start_time: props.event.start_time ? new Date(props.event.start_time).toISOString().slice(0, 16) : '',
  end_time: props.event.end_time ? new Date(props.event.end_time).toISOString().slice(0, 16) : '',
  event_type: props.event.event_type,
  status: props.event.status,
  priest_name: props.event.priest_name || '',
  activities: props.event.activities || '',
  room_id: props.event.room_id,
  _method: 'put',
});

const submit = (): void => {
  form.post(`/events/${props.event.id}`);
};
</script>

<template>
  <AppLayout>

    <Head title="Edit Event" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="mb-6">
              <h1 class="text-2xl font-semibold text-gray-900">Edit Event</h1>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
              <div>
                <Label for="title">Title</Label>
                <Input id="title" v-model="form.title" type="text" class="mt-1 block w-full" required autofocus />
                <InputError :message="form.errors.title" class="mt-2" />
              </div>

              <div>
                <Label for="description">Description</Label>
                <Textarea id="description" v-model="form.description" class="mt-1 block w-full" :rows="3" />
                <InputError :message="form.errors.description" class="mt-2" />
              </div>

              <div>
                <Label for="location">Location</Label>
                <Input id="location" v-model="form.location" type="text" class="mt-1 block w-full" required />
                <InputError :message="form.errors.location" class="mt-2" />
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <Label for="start_time">Start Time</Label>
                  <Input id="start_time" v-model="form.start_time" type="datetime-local" class="mt-1 block w-full"
                    required />
                  <InputError :message="form.errors.start_time" class="mt-2" />
                </div>

                <div>
                  <Label for="end_time">End Time</Label>
                  <Input id="end_time" v-model="form.end_time" type="datetime-local" class="mt-1 block w-full"
                    required />
                  <InputError :message="form.errors.end_time" class="mt-2" />
                </div>
              </div>

              <div>
                <Label for="event_type">Event Type</Label>
                <select id="event_type" v-model="form.event_type"
                  class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 text-sm">
                  <option disabled value="">-- Select an event --</option>
                  <option value="Mass">Mass</option>
                  <option value="Wedding">Wedding</option>
                  <option value="Baptism">Baptism</option>
                  <option value="Meeting">Meeting</option>
                  <option value="Other">Other</option>
                </select>
                <InputError :message="form.errors.event_type" class="mt-2" />
              </div>

              <div>
                <Label for="status">Status</Label>
                <select id="status" v-model="form.status"
                  class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 text-sm">
                  <option value="scheduled">Scheduled</option>
                  <option value="cancelled">Cancelled</option>
                  <option value="completed">Completed</option>
                </select>
                <InputError :message="form.errors.status" class="mt-2" />
              </div>

              <div>
                <Label for="priest_name">Priest Name</Label>
                <Input id="priest_name" v-model="form.priest_name" type="text" class="mt-1 block w-full" />
                <InputError :message="form.errors.priest_name" class="mt-2" />
              </div>

              <div>
                <Label for="activities">Activities</Label>
                <Textarea id="activities" v-model="form.activities" class="mt-1 block w-full" :rows="3" />
                <InputError :message="form.errors.activities" class="mt-2" />
              </div>

              <div class="mt-6">
                <Label for="room_id">Room (Optional)</Label>
                <select
                  id="room_id"
                  v-model="form.room_id"
                  class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 text-sm"
                >
                  <option :value="null">No Room</option>
                  <option 
                    v-for="room in rooms" 
                    :key="room.id" 
                    :value="room.id.toString()"
                    :disabled="room.status === 'occupied' || room.status === 'maintenance'"
                    :class="{
                      'text-red-500': room.status === 'occupied',
                      'text-yellow-500': room.status === 'maintenance',
                      'text-green-500': room.status === 'available'
                    }"
                  >
                    {{ room.name }} ({{ room.status }})
                  </option>
                </select>
                <div class="mt-2 text-xs text-gray-500">
                  <span class="text-green-500 mr-2">●</span> Available
                  <span class="text-red-500 mx-2">●</span> Occupied (cannot be selected)
                  <span class="text-yellow-500 mx-2">●</span> Maintenance (cannot be selected)
                </div>
                <InputError :message="form.errors.room_id" class="mt-2" />
              </div>

              <div class="flex items-center justify-end mt-4 space-x-4">
                <Link :href="`/events/${props.event.id}`"
                  class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                Cancel
                </Link>
                <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit">
                  Update Event
                </Button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>