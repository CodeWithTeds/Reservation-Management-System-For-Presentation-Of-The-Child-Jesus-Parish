<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservationController extends Controller
{
    /**
     * Display a listing of all reservations for admin management.
     */
    public function index()
    {
        $reservations = Reservation::with(['user', 'service'])
            ->orderBy('date_reserved', 'desc')
            ->get()
            ->map(function ($reservation) {
                return [
                    'reservation_id' => $reservation->reservation_id,
                    'user' => [
                        'id' => $reservation->user_id,
                        'name' => optional($reservation->user)->name,
                        'email' => optional($reservation->user)->email,
                    ],
                    'service' => [
                        'id' => $reservation->service_id,
                        'name' => optional($reservation->service)->service_type,
                    ],
                    'date_reserved' => optional($reservation->date_reserved)->format('Y-m-d'),
                    'time_start' => optional($reservation->time_start)->format('H:i'),
                    'time_end' => optional($reservation->time_end)->format('H:i'),
                    'status' => $reservation->status,
                    'remarks' => $reservation->remarks,
                    'created_at' => optional($reservation->created_at)->format('Y-m-d H:i:s'),
                ];
            });

        return Inertia::render('admin/Reservations/Index', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * Approve a reservation.
     */
    public function approve(Reservation $reservation)
    {
        if ($reservation->status !== 'Approved') {
            $reservation->status = 'Approved';
            $reservation->save();
        }
        return redirect()->back()->with('success', 'Reservation approved.');
    }

    /**
     * Cancel a reservation.
     */
    public function cancel(Reservation $reservation)
    {
        // Prevent cancellation of approved reservations
        if ($reservation->status === 'Approved') {
            return redirect()->back()->with('error', 'Approved reservations cannot be cancelled.');
        }
        
        if ($reservation->status !== 'Cancelled') {
            $reservation->status = 'Cancelled';
            $reservation->save();
        }
        return redirect()->back()->with('success', 'Reservation cancelled.');
    }

    /**
     * Update remarks for a reservation (and optionally status).
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'remarks' => ['nullable', 'string'],
            'status' => ['nullable', 'in:Pending,Approved,Cancelled'],
        ]);

        if (array_key_exists('remarks', $validated)) {
            $reservation->remarks = $validated['remarks'];
        }
        if (array_key_exists('status', $validated) && $validated['status']) {
            $reservation->status = $validated['status'];
        }
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation updated.');
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->back()->with('success', 'Reservation deleted.');
    }
}