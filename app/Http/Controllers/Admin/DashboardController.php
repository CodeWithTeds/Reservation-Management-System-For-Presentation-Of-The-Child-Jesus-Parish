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
     */
    public function index()
    {
        // Get counts for dashboard stats
        $totalReservations = Reservation::count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $approvedReservations = Reservation::where('status', 'approved')->count();
        $cancelledReservations = Reservation::where('status', 'cancelled')->count();
        
        $totalEvents = Event::count();
        $upcomingEvents = Event::where('start_time', '>', now())
            ->where('status', '!=', 'cancelled')
            ->count();
        $completedEvents = Event::where('status', 'completed')->count();
        
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        
        $totalServices = Service::count();
        $totalUsers = User::where('role', 'client')->count();
        
        // Get monthly reservation stats for the current year
        $monthlyReservations = $this->getMonthlyReservations();
        
        // Get service distribution
        $serviceDistribution = $this->getServiceDistribution();
        
        // Get room usage stats
        $roomUsage = $this->getRoomUsage();
        
        return Inertia::render('admin/Dashboard', [
            'stats' => [
                'reservations' => [
                    'total' => $totalReservations,
                    'pending' => $pendingReservations,
                    'approved' => $approvedReservations,
                    'cancelled' => $cancelledReservations,
                ],
                'events' => [
                    'total' => $totalEvents,
                    'upcoming' => $upcomingEvents,
                    'completed' => $completedEvents,
                ],
                'rooms' => [
                    'total' => $totalRooms,
                    'available' => $availableRooms,
                    'occupied' => $occupiedRooms,
                ],
                'services' => [
                    'total' => $totalServices,
                ],
                'users' => [
                    'total' => $totalUsers,
                ],
            ],
            'charts' => [
                'monthlyReservations' => $monthlyReservations,
                'serviceDistribution' => $serviceDistribution,
                'roomUsage' => $roomUsage,
            ],
        ]);
    }
    
    /**
     * Get monthly reservation stats for the current year.
     */
    private function getMonthlyReservations()
    {
        $year = Carbon::now()->year;
        $months = [];
        $reservationCounts = [];
        
        // Initialize all months with zero counts
        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create($year, $month, 1)->format('M');
            $months[] = $monthName;
            $reservationCounts[$monthName] = 0;
        }
        
        // Get reservation counts by month
        $reservations = Reservation::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();
        
        foreach ($reservations as $reservation) {
            $monthName = Carbon::create($year, $reservation->month, 1)->format('M');
            $reservationCounts[$monthName] = $reservation->count;
        }
        
        return [
            'labels' => $months,
            'data' => array_values($reservationCounts),
        ];
    }
    
    /**
     * Get service distribution stats.
     */
    private function getServiceDistribution()
    {
        $services = Service::withCount('reservations')->get();
        
        $labels = $services->pluck('service_type')->toArray();
        $data = $services->pluck('reservations_count')->toArray();
        
        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
    
    /**
     * Get room usage stats.
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