<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { computed } from 'vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import Badge from '@/components/ui/badge/Badge.vue'

interface UserInfo { id: number; name: string; email: string }
interface ServiceInfo { id: number; name: string }
interface AdminReservation {
  reservation_id: number
  user: UserInfo
  service: ServiceInfo
  date_reserved: string
  time_start: string
  time_end: string
  status: 'Pending' | 'Approved' | 'Cancelled'
  remarks?: string | null
  created_at: string
}

const props = defineProps<{ reservations: AdminReservation[] }>()
const reservations = computed<AdminReservation[]>(() => props.reservations || [])

const approveForm = useForm({})
const cancelForm = useForm({})
const updateForm = useForm<{ remarks: string | null; status?: string }>({ remarks: null })

const statusBadge = (status: string) => {
  switch (status) {
    case 'Approved':
      return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300'
    case 'Cancelled':
      return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'
    default:
      return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300'
  }
}

const total = computed(() => reservations.value.length)
const pending = computed(() => reservations.value.filter(r => r.status === 'Pending').length)
const approved = computed(() => reservations.value.filter(r => r.status === 'Approved').length)
const cancelled = computed(() => reservations.value.filter(r => r.status === 'Cancelled').length)

const approve = (id: number) => {
  approveForm.patch(route('admin.reservations.approve', id), { preserveScroll: true })
}
const cancel = (id: number) => {
  if (!confirm('Cancel this reservation?')) return
  cancelForm.patch(route('admin.reservations.cancel', id), { preserveScroll: true })
}

const saveRemarks = (id: number, remarks: string | null) => {
  updateForm.clearErrors()
  updateForm.transform(() => ({ remarks }))
  updateForm.put(route('admin.reservations.update', id), { preserveScroll: true })
}
</script>

<template>
  <Head title="Manage Reservations" />
  <AppLayout>
    <div class="mx-auto max-w-[95%] p-4 sm:p-6 lg:p-8">
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Reservations</h1>
          <p class="mt-1 text-gray-600 dark:text-gray-400">Manage all client reservations</p>
        </div>
        <div class="flex gap-2 text-sm">
          <span class="px-2 py-1 rounded bg-gray-100 dark:bg-gray-700">Total: {{ total }}</span>
          <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">Pending: {{ pending }}</span>
          <span class="px-2 py-1 rounded bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Approved: {{ approved }}</span>
          <span class="px-2 py-1 rounded bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">Cancelled: {{ cancelled }}</span>
        </div>
      </div>

      <Card>
        <CardHeader class="pb-2">
          <CardTitle>All Reservations</CardTitle>
          <CardDescription>Approve, cancel, or annotate reservations</CardDescription>
        </CardHeader>
        <CardContent>
          <div class="overflow-x-auto -mx-4 sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full align-middle px-4 sm:px-6 lg:px-8">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                  <tr>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                    <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                  <tr v-for="r in reservations" :key="r.reservation_id">
                    <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">#{{ r.reservation_id }}</td>
                    <td class="px-3 py-3 text-sm">
                      <div class="font-medium text-gray-900 dark:text-gray-100">{{ r.user?.name || '—' }}</div>
                      <div class="text-gray-500 text-xs">{{ r.user?.email }}</div>
                    </td>
                    <td class="px-3 py-3 text-sm">{{ r.service?.name }}</td>
                    <td class="px-3 py-3 text-sm">{{ r.date_reserved }}</td>
                    <td class="px-3 py-3 text-sm">{{ r.time_start }} - {{ r.time_end }}</td>
                    <td class="px-3 py-3 text-sm">
                      <span class="px-2 py-1 rounded text-xs font-medium" :class="statusBadge(r.status)">{{ r.status }}</span>
                    </td>
                    <td class="px-3 py-3 text-sm w-72">
                      <input
                        type="text"
                        :value="r.remarks || ''"
                        @change="(e:any) => saveRemarks(r.reservation_id, e.target.value)"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Add notes..."
                      />
                    </td>
                    <td class="px-3 py-3 text-sm text-right">
                      <div class="flex items-center justify-end gap-2">
                        <Button size="sm" variant="secondary" :disabled="r.status !== 'Pending'" @click="approve(r.reservation_id)">Approve</Button>
                        <Button size="sm" variant="destructive" :disabled="r.status === 'Cancelled' || r.status === 'Approved'" @click="cancel(r.reservation_id)">Cancel</Button>
                      </div>
                    </td>
                  </tr>
                  <tr v-if="reservations.length === 0">
                    <td colspan="8" class="px-6 py-12 text-center text-gray-500">No reservations found.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>