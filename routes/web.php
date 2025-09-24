<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

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
    Route::get('notifications', function () {
        return Inertia::render('client/Notifications');
    })->name('notifications');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
