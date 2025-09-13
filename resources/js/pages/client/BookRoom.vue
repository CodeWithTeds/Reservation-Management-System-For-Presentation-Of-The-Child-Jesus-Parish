<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card'

// Props from server
const props = defineProps<{
  services: Array<{ service_id: number; service_type: string }>
}>()

// Align with backend expected fields
const form = useForm({
  service_id: '',
  date_reserved: '',
  time_start: '',
  time_end: ''
})

const submit = () => {
  form.post(route('client.reservations.store'))
}
</script>

<template>
  <Head title="Book a Room" />
  <AppLayout>
    <div class="mx-auto w-full p-4 sm:p-6 lg:p-8">
      <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Book a Room</h1>
        <p class="mt-1 text-gray-600 dark:text-gray-400">Create a simple reservation</p>
      </div>

      <Card class="max-w-6xl mx-auto">
        <CardHeader>
          <CardTitle>New Reservation</CardTitle>
          <CardDescription>Fill out the details below</CardDescription>
        </CardHeader>
        <CardContent>
          <form @submit.prevent="submit" class="space-y-6">
            <!-- Service Selection (dynamic) -->
            <div>
              <label for="service_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Service</label>
              <select
                id="service_id"
                v-model="form.service_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                required
              >
                <option value="">Select a service</option>
                <option v-for="s in props.services" :key="s.service_id" :value="s.service_id">{{ s.service_type }}</option>
              </select>
              <div v-if="form.errors.service_id" class="text-red-500 mt-1 text-sm">{{ form.errors.service_id }}</div>
            </div>

            <!-- Date -->
            <div>
              <label for="date_reserved" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
              <input
                id="date_reserved"
                type="date"
                v-model="form.date_reserved"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                required
              />
              <div v-if="form.errors.date_reserved" class="text-red-500 mt-1 text-sm">{{ form.errors.date_reserved }}</div>
            </div>

            <!-- Time -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="time_start" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time</label>
                <input
                  id="time_start"
                  type="time"
                  v-model="form.time_start"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                  required
                />
                <div v-if="form.errors.time_start" class="text-red-500 mt-1 text-sm">{{ form.errors.time_start }}</div>
              </div>
              <div>
                <label for="time_end" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time</label>
                <input
                  id="time_end"
                  type="time"
                  v-model="form.time_end"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                  required
                />
                <div v-if="form.errors.time_end" class="text-red-500 mt-1 text-sm">{{ form.errors.time_end }}</div>
              </div>
            </div>

            <div class="flex justify-end gap-3">
              <Link :href="route('client.reservations')" class="inline-flex items-center px-4 py-2 bg-gray-600 rounded-md text-white text-xs font-semibold hover:bg-gray-700">
                Cancel
              </Link>
              <Button type="submit" :disabled="form.processing">
                {{ form.processing ? 'Booking…' : 'Book Now' }}
              </Button>
            </div>
          </form>
        </CardContent>
        <CardFooter />
      </Card>
    </div>
  </AppLayout>
</template>