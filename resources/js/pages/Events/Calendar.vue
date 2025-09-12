<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { onMounted, ref } from 'vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import { EventClickArg } from '@fullcalendar/core';
import { route } from 'ziggy-js';

type EventType = {
  id: number;
  title: string;
  description: string | null;
  location: string;
  start_time: string;
  end_time: string;
  event_type: string;
  status: string;
};

type CalendarEventType = {
  id: string;
  title: string;
  start: string;
  end: string;
  extendedProps: {
    description: string | null;
    location: string;
    event_type: string;
    status: string;
    originalId: number;
  };
  backgroundColor: string;
  borderColor: string;
  textColor: string;
  url: string;
};

const props = defineProps<{
  events: EventType[];
}>();

const calendarEvents = ref<CalendarEventType[]>([]);

onMounted(() => {
  // Transform the events data to the format expected by FullCalendar
  calendarEvents.value = props.events.map(event => ({
    id: String(event.id), // Convert to string for FullCalendar
    title: event.title,
    start: event.start_time,
    end: event.end_time,
    extendedProps: {
      description: event.description,
      location: event.location,
      event_type: event.event_type,
      status: event.status,
      originalId: event.id // Keep original numeric ID
    },
    backgroundColor: getEventColor(event.event_type),
    borderColor: getEventColor(event.event_type),
    textColor: '#ffffff',
    url: route('admin.events.show', event.id)
  }));
});

const getEventColor = (eventType: string): string => {
  switch (eventType) {
    case 'Mass':
      return '#4f46e5'; // indigo
    case 'Wedding':
      return '#ec4899'; // pink
    case 'Baptism':
      return '#0ea5e9'; // sky blue
    case 'Meeting':
      return '#f59e0b'; // amber
    default:
      return '#6b7280'; // gray
  }
};

const handleEventClick = (info: EventClickArg): void => {
  // Prevent the default URL navigation
  info.jsEvent.preventDefault();
  // Navigate using Inertia instead
  const eventId = info.event.extendedProps.originalId;
  router.visit(route('admin.events.show', eventId));
};
</script>

<template>
  <AppLayout>

    <Head title="Event Calendar" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-8 bg-white">
            <div class="flex justify-between items-center mb-8">
              <div>
                <h1 class="text-3xl font-bold text-gray-900">Event Calendar</h1>
                <div class="h-1 w-20 bg-indigo-500 mt-2 rounded"></div>
              </div>
              <div class="flex space-x-4">
                <Link :href="route('admin.events.index')">
                <Button variant="outline" class="border-gray-300 text-gray-700 hover:bg-gray-100">List View</Button>
                </Link>
                <Link :href="route('admin.events.create')">
                <Button class="bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">Add New Event</Button>
                </Link>
              </div>
            </div>

            <div class="calendar-container rounded-lg shadow-md overflow-hidden border border-gray-200">
              <FullCalendar :options="{
                plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                headerToolbar: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: calendarEvents,
                eventClick: handleEventClick,
                height: 'auto',
                eventTimeFormat: {
                  hour: '2-digit',
                  minute: '2-digit',
                  meridiem: 'short'
                }
              }" />
            </div>

            <div class="mt-8 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
              <h2 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Event Types</h2>
              <div class="flex flex-wrap gap-6">
                <div class="flex items-center">
                  <div class="w-5 h-5 rounded-full mr-2 bg-indigo-600"></div>
                  <span class="text-sm font-medium">Mass</span>
                </div>
                <div class="flex items-center">
                  <div class="w-5 h-5 rounded-full mr-2 bg-pink-500"></div>
                  <span class="text-sm font-medium">Wedding</span>
                </div>
                <div class="flex items-center">
                  <div class="w-5 h-5 rounded-full mr-2 bg-sky-500"></div>
                  <span class="text-sm font-medium">Baptism</span>
                </div>
                <div class="flex items-center">
                  <div class="w-5 h-5 rounded-full mr-2 bg-amber-500"></div>
                  <span class="text-sm font-medium">Meeting</span>
                </div>
                <div class="flex items-center">
                  <div class="w-5 h-5 rounded-full mr-2 bg-gray-500"></div>
                  <span class="text-sm font-medium">Other</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style>
/* Using Tailwind classes for FullCalendar components */
.fc-event {
  cursor: pointer;
}

.fc-event-title {
  font-weight: bold;
}

.fc-toolbar-title {
  font-size: 1.5rem !important;
  font-weight: 600 !important;
}

.fc-button-primary {
  background-color: rgb(79 70 229) !important;
  border-color: rgb(79 70 229) !important;
}

.fc-button-primary:hover {
  background-color: rgb(67 56 202) !important;
  border-color: rgb(67 56 202) !important;
}

.fc-button-primary:disabled {
  background-color: rgb(107 114 128) !important;
  border-color: rgb(107 114 128) !important;
}

.fc-daygrid-day.fc-day-today {
  background-color: rgb(238 242 255) !important;
}
</style>