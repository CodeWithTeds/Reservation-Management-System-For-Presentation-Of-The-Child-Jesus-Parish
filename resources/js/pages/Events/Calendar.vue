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
    url: `/events/${event.id}`
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
  router.visit(`/events/${eventId}`);
};
</script>

<template>
  <AppLayout>
    <Head title="Event Calendar" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
              <h1 class="text-2xl font-semibold text-gray-900">Event Calendar</h1>
              <div class="flex space-x-4">
                <Link href="/events">
                  <Button variant="outline">List View</Button>
                </Link>
                <Link href="/events/create">
                  <Button>Add New Event</Button>
                </Link>
              </div>
            </div>

            <div class="calendar-container">
              <FullCalendar
                :options="{
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
                }"
              />
            </div>

            <div class="mt-6">
              <h2 class="text-lg font-medium text-gray-900 mb-3">Event Types</h2>
              <div class="flex flex-wrap gap-4">
                <div class="flex items-center">
                  <div class="w-4 h-4 rounded-full mr-2" style="background-color: #4f46e5"></div>
                  <span>Mass</span>
                </div>
                <div class="flex items-center">
                  <div class="w-4 h-4 rounded-full mr-2" style="background-color: #ec4899"></div>
                  <span>Wedding</span>
                </div>
                <div class="flex items-center">
                  <div class="w-4 h-4 rounded-full mr-2" style="background-color: #0ea5e9"></div>
                  <span>Baptism</span>
                </div>
                <div class="flex items-center">
                  <div class="w-4 h-4 rounded-full mr-2" style="background-color: #f59e0b"></div>
                  <span>Meeting</span>
                </div>
                <div class="flex items-center">
                  <div class="w-4 h-4 rounded-full mr-2" style="background-color: #6b7280"></div>
                  <span>Other</span>
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
/* Add any custom styles for the calendar here */
.fc-event {
  cursor: pointer;
}

.fc-event-title {
  font-weight: bold;
}

.fc-toolbar-title {
  font-size: 1.5rem !important;
  font-weight: 600;
}

.fc-button-primary {
  background-color: #4f46e5 !important;
  border-color: #4f46e5 !important;
}

.fc-button-primary:hover {
  background-color: #4338ca !important;
  border-color: #4338ca !important;
}

.fc-button-primary:disabled {
  background-color: #6b7280 !important;
  border-color: #6b7280 !important;
}

.fc-daygrid-day.fc-day-today {
  background-color: rgba(79, 70, 229, 0.1) !important;
}
</style>