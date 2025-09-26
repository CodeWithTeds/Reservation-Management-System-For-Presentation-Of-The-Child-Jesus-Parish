<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    // Redirect admin users to admin dashboard, client users to client dashboard
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return Inertia::render('Dashboard');
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
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->only(['index', 'show', 'destroy']);
    Route::patch('reservations/{reservation}/approve', [App\Http\Controllers\Admin\ReservationController::class, 'approve'])->name('reservations.approve');
    Route::patch('reservations/{reservation}/cancel', [App\Http\Controllers\Admin\ReservationController::class, 'cancel'])->name('reservations.cancel');

    // Livestream Management Routes
    Route::get('livestreams/create', [App\Http\Controllers\Admin\LivestreamController::class, 'create'])->name('livestreams.create');
    Route::post('livestreams', [App\Http\Controllers\Admin\LivestreamController::class, 'store'])->name('livestreams.store');

    // Notifications Management Routes
    Route::get('notifications/create', [App\Http\Controllers\Admin\NotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notifications.store');
});

// Client Routes
Route::prefix('client')->name('client.')->middleware(['auth', 'verified', 'client'])->group(function () {
    // Client Dashboard
    Route::get('dashboard', function () {
        return Inertia::render('client/Dashboard');
    })->name('dashboard');
    
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
