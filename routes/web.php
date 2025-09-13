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

Route::get('admin/dashboard', function () {
    // Debug the user role
    if (Auth::check()) {
        // Log or dump the user role for debugging
        // dd(Auth::user()->role);
    }
    return Inertia::render('admin/Dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    // Event Management Routes
    Route::resource('events', EventController::class);
    Route::get('events-calendar', [EventController::class, 'calendar'])->name('events.calendar');
    
    // Room Management Routes
    Route::resource('rooms', RoomController::class);
    
    // Service Management Routes
    Route::resource('services', App\Http\Controllers\ServiceController::class);
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
    Route::get('reservations', function () {
        return Inertia::render('client/Reservations');
    })->name('reservations');
    
    // Book a Room
    Route::get('book', function () {
        return Inertia::render('client/BookRoom');
    })->name('book');
    
    // Client Notifications
    Route::get('notifications', function () {
        return Inertia::render('client/Notifications');
    })->name('notifications');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
