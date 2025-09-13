<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { CalendarCheck, Eye, Edit, Trash2, Clock, Calendar, MessageSquare } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import Badge from '@/components/ui/badge/Badge.vue';
import { Reservation } from '@/types';
import { route } from 'ziggy-js';

// Props from server via Inertia
const props = defineProps<{
  reservations: Reservation[];
  stats: {
    total: number;
    pending: number;
    approved: number;
    cancelled: number;
  };
}>();

// Local state derived from props
const reservations = ref<Reservation[]>(props.reservations || []);
const stats = ref({
  total: props.stats?.total ?? 0,
  pending: props.stats?.pending ?? 0,
  approved: props.stats?.approved ?? 0,
  cancelled: props.stats?.cancelled ?? 0,
});

// Sync when Inertia updates props (e.g., after cancel or reload)
watch(
  () => props.reservations,
  (val) => {
    reservations.value = val || [];
  },
  { deep: true }
);
watch(
  () => props.stats,
  (val) => {
    if (!val) return;
    stats.value = { ...val } as typeof stats.value;
  },
  { deep: true }
);

// Loading and error states (no API call; default to ready)
const isLoading = ref(false);
const error = ref<string | null>(null);

// Optional: allow manual refresh using Inertia to fetch fresh props
const fetchReservations = () => {
  isLoading.value = true;
  error.value = null;
  router.reload({
    only: ['reservations', 'stats'],
    onFinish: () => {
      isLoading.value = false;
    },
  });
};

// Cancel a reservation via Inertia PATCH to web route
const cancelForm = useForm({});
const cancelReservation = (reservationId: number) => {
  if (!confirm('Are you sure you want to cancel this reservation?')) {
    return;
  }

  cancelForm.patch(route('client.reservations.cancel', reservationId), {
    preserveScroll: true,
    onSuccess: () => {
      // Optimistically update local state for snappier UI (server will also refresh props)
      const index = reservations.value.findIndex((r) => r.reservation_id === reservationId);
      if (index !== -1 && reservations.value[index].status === 'Pending') {
        reservations.value[index].status = 'Cancelled';
        stats.value.pending = Math.max(0, stats.value.pending - 1);
        stats.value.cancelled = (stats.value.cancelled || 0) + 1;
      }
    },
    onError: () => {
      alert('Failed to cancel reservation. Please try again later.');
    },
  });
};

// Format date function
const formatDate = (dateString: string) => {
  const options: Intl.DateTimeFormatOptions = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};

// Get status badge variant
const getStatusVariant = (status: string) => {
  switch (status) {
    case 'Approved':
      return 'success';
    case 'Pending':
      return 'warning';
    case 'Cancelled':
      return 'destructive';
    default:
      return 'secondary';
  }
};

// Get status badge color (for backward compatibility)
const getStatusColor = (status: string) => {
  switch (status) {
    case 'Approved':
      return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
    case 'Pending':
      return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
    case 'Cancelled':
      return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
    default:
      return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
  }
};

// Get status icon
const getStatusIcon = (status: string) => {
  switch (status) {
    case 'Approved':
      return 'check-circle';
    case 'Pending':
      return 'clock';
    case 'Cancelled':
      return 'x-circle';
    default:
      return 'help-circle';
  }
};
</script>

<template>
  <Head title="My Reservations" />
  <AppLayout>
    <div class="mx-auto max-w-7xl p-4 sm:p-6 lg:p-8">
      <div class="flex justify-between items-center mb-6">
        <div>
          <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">My Reservations</h1>
          <p class="mt-1 text-gray-600 dark:text-gray-400">View and manage your service reservations</p>
        </div>
        <Link :href="route('client.book')">
          <Button class="inline-flex items-center">
            <CalendarCheck class="mr-2 h-4 w-4" />
            Book New Reservation
          </Button>
        </Link>
      </div>

      <!-- Responsive Table for Reservations -->
      <Card class="shadow-sm">
        <CardHeader class="pb-2">
          <CardTitle>Reservation History</CardTitle>
          <CardDescription>All your past and upcoming reservations</CardDescription>
        </CardHeader>
        <CardContent>
          <!-- Loading state -->
          <div v-if="isLoading" class="py-12 text-center">
            <div class="flex flex-col items-center">
              <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-700 mb-4"></div>
              <p class="text-gray-500 dark:text-gray-400">Loading your reservations...</p>
            </div>
          </div>

          <!-- Error state -->
          <div v-else-if="error" class="py-12 text-center">
            <div class="flex flex-col items-center">
              <div class="text-red-500 mb-4 text-5xl">!</div>
              <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Something went wrong</h3>
              <p class="text-gray-500 dark:text-gray-400 mb-4">{{ error }}</p>
              <Button @click="fetchReservations">
                Try Again
              </Button>
            </div>
          </div>

          <!-- Data loaded successfully -->
          <div v-else class="overflow-x-auto">
            <table class="w-full text-sm text-left">
              <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-800">
                <tr>
                  <th scope="col" class="px-6 py-3 rounded-l-lg">ID</th>
                  <th scope="col" class="px-6 py-3">Service</th>
                  <th scope="col" class="px-6 py-3 hidden md:table-cell">
                    <div class="flex items-center">
                      <Calendar class="mr-1 h-4 w-4" />
                      Date
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3 hidden sm:table-cell">
                    <div class="flex items-center">
                      <Clock class="mr-1 h-4 w-4" />
                      Time
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3">Status</th>
                  <th scope="col" class="px-6 py-3 hidden md:table-cell">
                    <div class="flex items-center">
                      <MessageSquare class="mr-1 h-4 w-4" />
                      Remarks
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3 rounded-r-lg">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="reservation in reservations"
                  :key="reservation.reservation_id"
                  class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                >
                  <td class="px-6 py-4 font-medium">
                    #{{ reservation.reservation_id }}
                  </td>
                  <td class="px-6 py-4">
                    {{ reservation.service_name }}
                  </td>
                  <td class="px-6 py-4 hidden md:table-cell">
                    {{ formatDate(reservation.date_reserved) }}
                  </td>
                  <td class="px-6 py-4 hidden sm:table-cell">
                    {{ reservation.time_start }} - {{ reservation.time_end }}
                  </td>
                  <td class="px-6 py-4">
                    <Badge :variant="getStatusVariant(reservation.status)" class="font-medium">
                      {{ reservation.status }}
                    </Badge>
                  </td>
                  <td class="px-6 py-4 hidden md:table-cell">
                    <div v-if="reservation.remarks" class="flex items-start">
                      <p class="text-sm text-gray-600 dark:text-gray-300">{{ reservation.remarks }}</p>
                    </div>
                    <span v-else class="text-gray-400 dark:text-gray-600 text-sm italic">No remarks</span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex space-x-2">
                      <Button
                        v-if="reservation.status === 'Pending'"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400"
                        title="Cancel Reservation"
                        @click="() => cancelReservation(reservation.reservation_id)"
                      >
                        <Trash2 class="h-4 w-4" />
                      </Button>
                    </div>
                  </td>
                </tr>
                <!-- Empty state when no reservations -->
                <tr v-if="reservations.length === 0" class="bg-white dark:bg-gray-900">
                  <td colspan="7" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center">
                      <CalendarCheck class="h-12 w-12 text-gray-400 dark:text-gray-600 mb-4" />
                      <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No reservations found</h3>
                      <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't made any reservations yet.</p>
                      <Link :href="route('client.book')">
                        <Button class="inline-flex items-center">
                          Book Your First Reservation
                        </Button>
                      </Link>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </CardContent>
      </Card>

      <!-- Reservation Details Section -->
      <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Upcoming Reservations Card -->
        <Card>
          <CardHeader>
            <CardTitle class="text-lg">Upcoming</CardTitle>
            <CardDescription>Your next scheduled reservations</CardDescription>
          </CardHeader>
          <CardContent>
            <div class="space-y-4">
              <div
                v-for="reservation in reservations.filter(r => r.status !== 'Cancelled')"
                :key="reservation.reservation_id"
                class="p-3 rounded-lg border border-gray-200 dark:border-gray-700"
              >
                <div class="flex justify-between items-start">
                  <div>
                    <h4 class="font-medium text-gray-900 dark:text-white">{{ reservation.service_name }}</h4>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                      <Calendar class="h-3.5 w-3.5 mr-1" />
                      {{ formatDate(reservation.date_reserved) }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                      <Clock class="h-3.5 w-3.5 mr-1" />
                      {{ reservation.time_start }} - {{ reservation.time_end }}
                    </div>
                  </div>
                  <Badge :class="getStatusColor(reservation.status)">
                    {{ reservation.status }}
                  </Badge>
                </div>
                <div v-if="reservation.remarks" class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-800">
                  <div class="flex items-start">
                    <MessageSquare class="h-4 w-4 text-gray-400 mr-1.5 mt-0.5" />
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ reservation.remarks }}</p>
                  </div>
                </div>
              </div>
              <div v-if="!reservations.some(r => r.status !== 'Cancelled')" class="text-center py-6">
                <p class="text-gray-500 dark:text-gray-400">No upcoming reservations</p>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Quick Stats Card -->
        <Card>
          <CardHeader>
            <CardTitle class="text-lg">Reservation Stats</CardTitle>
            <CardDescription>Your reservation activity</CardDescription>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-2 gap-4">
              <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ reservations.length }}</p>
              </div>
              <div class="bg-green-50 dark:bg-green-900/30 p-4 rounded-lg text-center">
                <p class="text-sm text-green-600 dark:text-green-400">Approved</p>
                <p class="text-2xl font-semibold text-green-700 dark:text-green-400">
                  {{ reservations.filter(r => r.status === 'Approved').length }}
                </p>
              </div>
              <div class="bg-yellow-50 dark:bg-yellow-900/30 p-4 rounded-lg text-center">
                <p class="text-sm text-yellow-600 dark:text-yellow-400">Pending</p>
                <p class="text-2xl font-semibold text-yellow-700 dark:text-yellow-400">
                  {{ reservations.filter(r => r.status === 'Pending').length }}
                </p>
              </div>
              <div class="bg-red-50 dark:bg-red-900/30 p-4 rounded-lg text-center">
                <p class="text-sm text-red-600 dark:text-red-400">Cancelled</p>
                <p class="text-2xl font-semibold text-red-700 dark:text-red-400">
                  {{ reservations.filter(r => r.status === 'Cancelled').length }}
                </p>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Help Card -->
        <Card>
          <CardHeader>
            <CardTitle class="text-lg">Need Help?</CardTitle>
            <CardDescription>Reservation assistance</CardDescription>
          </CardHeader>
          <CardContent>
            <div class="space-y-4">
              <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <h4 class="font-medium text-blue-700 dark:text-blue-400 mb-2">Booking Guidelines</h4>
                <ul class="text-sm text-blue-600 dark:text-blue-300 space-y-1 list-disc pl-5">
                  <li>Book at least 3 days in advance</li>
                  <li>Cancellations must be made 24 hours before</li>
                  <li>Arrive 15 minutes before your scheduled time</li>
                </ul>
              </div>
              <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                <h4 class="font-medium text-purple-700 dark:text-purple-400 mb-2">Contact Support</h4>
                <p class="text-sm text-purple-600 dark:text-purple-300">
                  Need assistance with your reservation? Contact our support team at
                  <a href="mailto:support@pcjp.org" class="underline">support@pcjp.org</a> or call (123) 456-7890.
                </p>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>

</style>