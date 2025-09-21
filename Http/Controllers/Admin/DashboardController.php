<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Get reservation statistics
        $reservationStats = [
            'total' => Reservation::count(),
            'pending' => Reservation::where('status', 'pending')->count(),
            'approved' => Reservation::where('status', 'approved')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];

        // Get event statistics
        $now = Carbon::now();
        $eventStats = [
            'total' => Event::count(),
            'upcoming' => Event::where('start_time', '>', $now)->count(),
            'completed' => Event::where('end_time', '<', $now)->count(),
        ];

        // Get room statistics
        $roomStats = [
            'total' => Room::count(),
            'available' => Room::where('is_occupied', false)->count(),
            'occupied' => Room::where('is_occupied', true)->count(),
        ];

        // Get service statistics
        $serviceStats = [
            'total' => Service::count(),
        ];

        // Get user statistics
        $userStats = [
            'total' => User::where('role', 'client')->count(),
        ];

        // Get monthly reservations for the current year
        $monthlyReservations = $this->getMonthlyReservations();

        // Get service distribution
        $serviceDistribution = $this->getServiceDistribution();

        // Get room usage
        $roomUsage = $this->getRoomUsage();

        return Inertia::render('admin/Dashboard', [
            'stats' => [
                'reservations' => $reservationStats,
                'events' => $eventStats,
                'rooms' => $roomStats,
                'services' => $serviceStats,
                'users' => $userStats,
            ],
            'charts' => [
                'monthlyReservations' => $monthlyReservations,
                'serviceDistribution' => $serviceDistribution,
                'roomUsage' => $roomUsage,
            ],
        ]);
    }

    /**
     * Get monthly reservations for the current year.
     *
     * @return array
     */
    private function getMonthlyReservations()
    {
        $year = Carbon::now()->year;
        $months = [];
        $data = [];

        // Get all months
        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::createFromDate($year, $i, 1);
            $months[] = $month->format('M');

            // Count reservations for this month
            $count = Reservation::whereYear('created_at', $year)
                ->whereMonth('created_at', $i)
                ->count();

            $data[] = $count;
        }

        return [
            'labels' => $months,
            'data' => $data,
        ];
    }

    /**
     * Get service distribution data.
     *
     * @return array
     */
    private function getServiceDistribution()
    {
        $services = Service::withCount('reservations')->get();
        
        $labels = $services->pluck('name')->toArray();
        $data = $services->pluck('reservations_count')->toArray();
        
        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
    
    /**
     * Get room usage data.
     *
     * @return array
     */
    private function getRoomUsage()
    {
        $rooms = Room::withCount('events')->get();
        
        $labels = $rooms->pluck('name')->toArray();
        $data = $rooms->pluck('events_count')->toArray();
        
        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

}