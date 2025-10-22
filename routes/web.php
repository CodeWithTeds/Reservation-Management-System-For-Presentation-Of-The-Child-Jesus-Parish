<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Reservation;

Route::get('/', function () {
    // Get the latest livestream marked as live or, if none live, the latest scheduled/created
    $livestream = \App\Models\Livestream::orderByDesc('is_live')
        ->orderByDesc('scheduled_at')
        ->orderByDesc('created_at')
        ->first();
        
    return Inertia::render('Welcome', [
        'livestream' => $livestream ? [
            'id' => $livestream->id,
            'title' => $livestream->title,
            'platform' => $livestream->platform,
            'url' => $livestream->url,
            'is_live' => (bool) $livestream->is_live,
            'scheduled_at' => optional($livestream->scheduled_at)?->toDateTimeString(),
        ] : null,
    ]);
})->name('home');

// Public Livestream page
Route::get('/livestream', [\App\Http\Controllers\LivestreamController::class, 'show'])->name('livestream');

// About page
Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/livestream-scroll', function () {
    $livestream = App\Models\Livestream::where('is_live', true)
        ->orWhere(function($query) {
            $query->whereNull('is_live')
                  ->orWhere('is_live', false);
        })
        ->orderBy('is_live', 'desc')
        ->orderBy('created_at', 'desc')
        ->first();
        
    return Inertia::render('LivestreamScroll', [
        'livestream' => $livestream ? [
            'id' => $livestream->id,
            'title' => $livestream->title,
            'platform' => $livestream->platform,
            'url' => $livestream->url,
            'is_live' => $livestream->is_live,
        ] : null
    ]);
})->name('livestream.scroll');

Route::get('/livestream-page', function () {
    $livestream = App\Models\Livestream::where('is_live', true)
        ->orWhere(function($query) {
            $query->whereNull('is_live')
                  ->orWhere('is_live', false);
        })
        ->orderBy('is_live', 'desc')
        ->orderBy('created_at', 'desc')
        ->first();
        
    return Inertia::render('LivestreamPage', [
        'livestream' => $livestream ? [
            'id' => $livestream->id,
            'title' => $livestream->title,
            'platform' => $livestream->platform,
            'url' => $livestream->url,
            'is_live' => $livestream->is_live,
        ] : null
    ]);
})->name('livestream.page');

Route::get('/livestream-display', function () {
    $livestream = App\Models\Livestream::where('is_live', true)
        ->orWhere(function($query) {
            $query->whereNull('is_live')
                  ->orWhere('is_live', false);
        })
        ->orderBy('is_live', 'desc')
        ->orderBy('created_at', 'desc')
        ->first();
        
    return Inertia::render('LivestreamDisplay', [
        'livestream' => $livestream ? [
            'id' => $livestream->id,
            'title' => $livestream->title,
            'platform' => $livestream->platform,
            'url' => $livestream->url,
            'is_live' => $livestream->is_live,
        ] : null
    ]);
})->name('livestream.display');

Route::get('dashboard', function () {
    // Redirect based on role
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::user()->role === 'staff') {
            return redirect()->route('staff.dashboard');
        }
    }

    $user = Auth::user();

    // Fetch user-specific reservations with service info
    $reservationsQuery = Reservation::with('service')
        ->where('user_id', optional($user)->id)
        ->orderBy('date_reserved', 'desc');

    $reservations = $reservationsQuery->get()->map(function ($reservation) {
        return [
            'reservation_id' => $reservation->reservation_id,
            'service_id' => $reservation->service_id,
            'service_name' => optional($reservation->service)->service_type,
            'date_reserved' => optional($reservation->date_reserved)?->format('Y-m-d'),
            'time_start' => optional($reservation->time_start)?->format('H:i'),
            'time_end' => optional($reservation->time_end)?->format('H:i'),
            'status' => $reservation->status,
            'remarks' => $reservation->remarks,
        ];
    });

    $stats = [
        'total' => $reservations->count(),
        'pending' => $reservations->where('status', 'Pending')->count(),
        'approved' => $reservations->where('status', 'Approved')->count(),
        'cancelled' => $reservations->where('status', 'Cancelled')->count(),
    ];

    // Upcoming reservations (next 3)
    $upcoming = $reservationsQuery->clone()
        ->where('status', '!=', 'Cancelled')
        ->whereDate('date_reserved', '>=', now()->toDateString())
        ->orderBy('date_reserved')
        ->limit(3)
        ->get()
        ->map(function ($reservation) {
            return [
                'reservation_id' => $reservation->reservation_id,
                'service_name' => optional($reservation->service)->service_type,
                'date_reserved' => optional($reservation->date_reserved)?->format('Y-m-d'),
                'time_start' => optional($reservation->time_start)?->format('H:i'),
                'time_end' => optional($reservation->time_end)?->format('H:i'),
                'status' => $reservation->status,
            ];
        });

    return Inertia::render('client/Dashboard', [
        'reservations' => $reservations,
        'stats' => $stats,
        'upcoming' => $upcoming,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    // Event Management Routes
    Route::resource('events', EventController::class);
    Route::get('events-calendar', [EventController::class, 'calendar'])->name('events.calendar');
    
    // Room Management Routes
    Route::resource('rooms', RoomController::class);
    
    // Service Management Routes
    Route::resource('services', App\Http\Controllers\ServiceController::class);

    // Reservation Management Routes (Admin)
    Route::resource('reservations', App\Http\Controllers\Admin\ReservationController::class)->only(['index','update','destroy']);

    // User Management Routes
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->only(['index', 'show', 'destroy', 'create', 'store']);
    Route::patch('reservations/{reservation}/approve', [App\Http\Controllers\Admin\ReservationController::class, 'approve'])->name('reservations.approve');
    Route::patch('reservations/{reservation}/cancel', [App\Http\Controllers\Admin\ReservationController::class, 'cancel'])->name('reservations.cancel');

    // Livestream Management Routes
    Route::get('livestreams/create', [App\Http\Controllers\Admin\LivestreamController::class, 'create'])->name('livestreams.create');
    Route::post('livestreams', [App\Http\Controllers\Admin\LivestreamController::class, 'store'])->name('livestreams.store');

    // Notifications Management Routes
    Route::get('notifications/create', [App\Http\Controllers\Admin\NotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notifications.store');
});

// Staff Routes (URL alias to admin management with staff-friendly prefix)
Route::prefix('staff')->name('staff.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    // Staff Dashboard (shares admin dashboard UI)
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Room Management (same controller as admin)
    Route::resource('rooms', RoomController::class);

    // Service Management (same controller as admin)
    Route::resource('services', \App\Http\Controllers\ServiceController::class);

    // Reservation Management (Admin controller UI)
    Route::resource('reservations', \App\Http\Controllers\Admin\ReservationController::class)->only(['index','update','destroy']);
});

// Client Routes
Route::prefix('client')->name('client.')->middleware(['auth', 'verified', 'client'])->group(function () {
    // Client Dashboard
    
    // Client Events
    Route::get('events', function () {
        return Inertia::render('client/Events');
    })->name('events');
    
    // Client Reservations
    Route::get('reservations', [\App\Http\Controllers\ReservationController::class, 'index'])->name('reservations');
    Route::get('reservations/create', [\App\Http\Controllers\ReservationController::class, 'create'])->name('reservations.create');
    Route::post('reservations', [\App\Http\Controllers\ReservationController::class, 'store'])->name('reservations.store');
    Route::get('reservations/{reservation}', [\App\Http\Controllers\ReservationController::class, 'show'])->name('reservations.show');
    Route::patch('reservations/{reservation}/cancel', [\App\Http\Controllers\ReservationController::class, 'cancel'])->name('reservations.cancel');
    
    // Book a Room (use controller so services are provided)
    Route::get('book', [\App\Http\Controllers\ReservationController::class, 'create'])->name('book');
    
    // Client Notifications
    Route::get('notifications', [\App\Http\Controllers\Client\NotificationController::class, 'index'])->name('notifications');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
