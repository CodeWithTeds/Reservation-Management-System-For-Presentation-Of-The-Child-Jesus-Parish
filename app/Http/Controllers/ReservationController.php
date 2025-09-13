<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReservationController extends Controller
{
    /**
     * Display a listing of the reservations for the authenticated user.
     */
    public function index()
    {
        $reservations = Reservation::with('service')
            ->where('user_id', Auth::id())
            ->orderBy('date_reserved', 'desc')
            ->get()
            ->map(function ($reservation) {
                return [
                    'reservation_id' => $reservation->reservation_id,
                    'user_id' => $reservation->user_id,
                    'service_id' => $reservation->service_id,
                    'date_reserved' => $reservation->date_reserved->format('Y-m-d'),
                    'time_start' => $reservation->time_start->format('H:i'),
                    'time_end' => $reservation->time_end->format('H:i'),
                    'status' => $reservation->status,
                    'remarks' => $reservation->remarks,
                    'service_name' => $reservation->service->service_type,
                ];
            });

        // Get counts for stats
        $totalCount = $reservations->count();
        $pendingCount = $reservations->where('status', 'Pending')->count();
        $approvedCount = $reservations->where('status', 'Approved')->count();
        $cancelledCount = $reservations->where('status', 'Cancelled')->count();

        return Inertia::render('client/Reservations', [
            'reservations' => $reservations,
            'stats' => [
                'total' => $totalCount,
                'pending' => $pendingCount,
                'approved' => $approvedCount,
                'cancelled' => $cancelledCount,
            ],
        ]);
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create()
    {
        $services = Service::all();
        return Inertia::render('client/BookRoom', [
            'services' => $services,
        ]);
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,service_id',
            'date_reserved' => 'required|date|after_or_equal:today',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
        ]);

        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->service_id = $validated['service_id'];
        $reservation->date_reserved = $validated['date_reserved'];
        $reservation->time_start = $validated['time_start'];
        $reservation->time_end = $validated['time_end'];
        $reservation->status = 'Pending';
        $reservation->save();

        return redirect()->route('client.reservations')->with('success', 'Reservation created successfully!');
    }

    /**
     * Display the specified reservation.
     */
    public function show(Reservation $reservation)
    {
        // Check if the reservation belongs to the authenticated user
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('client/Reservations/Show', [
            'reservation' => [
                'reservation_id' => $reservation->reservation_id,
                'user_id' => $reservation->user_id,
                'service_id' => $reservation->service_id,
                'date_reserved' => $reservation->date_reserved->format('Y-m-d'),
                'time_start' => $reservation->time_start->format('H:i'),
                'time_end' => $reservation->time_end->format('H:i'),
                'status' => $reservation->status,
                'remarks' => $reservation->remarks,
                'service' => $reservation->service,
                'created_at' => $reservation->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $reservation->updated_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * Cancel the specified reservation.
     */
    public function cancel(Reservation $reservation)
    {
        // Check if the reservation belongs to the authenticated user
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow cancellation of pending reservations
        if ($reservation->status !== 'Pending') {
            return back()->with('error', 'Only pending reservations can be cancelled.');
        }

        $reservation->status = 'Cancelled';
        $reservation->save();

        return redirect()->route('client.reservations')->with('success', 'Reservation cancelled successfully!');
    }
}