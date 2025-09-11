<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Event Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('events', EventController::class);
    Route::get('events-calendar', [EventController::class, 'calendar'])->name('events.calendar');
});

// Room Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('rooms', RoomController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
