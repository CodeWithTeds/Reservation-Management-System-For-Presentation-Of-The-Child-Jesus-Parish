<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import Textarea from '@/components/ui/textarea/textarea.vue';

import InputError from '@/components/InputError.vue';

interface EventForm {
  title: string;
  description: string;
  location: string;
  start_time: string;
  end_time: string;
  event_type: string;
  status: string;
}

const form = useForm<EventForm>({
  title: '',
  description: '',
  location: '',
  start_time: '',
  end_time: '',
  event_type: '',
  status: 'scheduled',
});

const submit = (): void => {
  form.post('/events');
};
</script>

<template>
  <AppLayout>
    <Head title="Create Event" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="mb-6">
              <h1 class="text-2xl font-semibold text-gray-900">Create New Event</h1>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
              <div>
                <Label for="title">Title</Label>
                <Input
                  id="title"
                  v-model="form.title"
                  type="text"
                  class="mt-1 block w-full"
                  required
                  autofocus
                />
                <InputError :message="form.errors.title" class="mt-2" />
              </div>

              <div>
                <Label for="description">Description</Label>
                <Textarea
                  id="description"
                  v-model="form.description"
                  class="mt-1 block w-full"
                  :rows="3"
                />
                <InputError :message="form.errors.description" class="mt-2" />
              </div>

              <div>
                <Label for="location">Location</Label>
                <Input
                  id="location"
                  v-model="form.location"
                  type="text"
                  class="mt-1 block w-full"
                  required
                />
                <InputError :message="form.errors.location" class="mt-2" />
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <Label for="start_time">Start Time</Label>
                  <Input
                    id="start_time"
                    v-model="form.start_time"
                    type="datetime-local"
                    class="mt-1 block w-full"
                    required
                  />
                  <InputError :message="form.errors.start_time" class="mt-2" />
                </div>

                <div>
                  <Label for="end_time">End Time</Label>
                  <Input
                    id="end_time"
                    v-model="form.end_time"
                    type="datetime-local"
                    class="mt-1 block w-full"
                    required
                  />
                  <InputError :message="form.errors.end_time" class="mt-2" />
                </div>
              </div>

              <div>
                <Label for="event_type">Event Type</Label>
                <select
                  id="event_type"
                  v-model="form.event_type"
                  class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 text-sm"
                >
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
                <select
                  id="status"
                  v-model="form.status"
                  class="mt-1 block w-full rounded-md border border-gray-300 bg-white p-2 text-sm"
                >
                  <option value="scheduled">Scheduled</option>
                  <option value="cancelled">Cancelled</option>
                  <option value="completed">Completed</option>
                </select>
                <InputError :message="form.errors.status" class="mt-2" />
              </div>
              

              <div class="mt-4 flex justify-end space-x-4">
                <a href="/events" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                  Cancel
                </a>
                <Button
                  type="submit"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
                  Create Event
                </Button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>