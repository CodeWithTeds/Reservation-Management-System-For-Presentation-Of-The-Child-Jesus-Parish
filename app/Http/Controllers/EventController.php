<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['creator', 'room'])->latest()->get();
        
        return Inertia::render('Events/Index', [
            'events' => $events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all rooms that are not in maintenance
        $rooms = Room::where('status', '!=', 'maintenance')->get();
        
        // Check for rooms that are occupied by ongoing events
        $rooms = $rooms->map(function ($room) {
            // Find any scheduled events that are currently using this room
            $hasOngoingEvent = Event::where('room_id', $room->id)
                ->where('status', '!=', 'completed')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereDate('start_time', '<=', now())
                          ->whereDate('end_time', '>=', now());
                    });
                })
                ->exists();
            
            // If room has an ongoing event, mark it as occupied
            if ($hasOngoingEvent && $room->status === 'available') {
                $room->status = 'occupied';
            }
            
            return $room;
        });
        
        return Inertia::render('Events/Create', [
            'rooms' => $rooms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'event_type' => 'required|string|max:255',
            'status' => 'required|string|in:scheduled,cancelled,completed',
            'priest_name' => 'nullable|string|max:255',
            'activities' => 'nullable|string',
            'room_id' => 'nullable|exists:rooms,id',
        ]);

        $event = Event::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        // If a room is assigned and the event is not completed, mark the room as occupied
        if ($event->room_id && $event->status !== 'completed') {
            $room = Room::find($event->room_id);
            if ($room && $room->status === 'available') {
                $room->status = 'occupied';
                $room->save();
            }
        }

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return Inertia::render('Events/Show', [
            'event' => $event->load('creator')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        // Get all rooms that are not in maintenance
        $rooms = Room::where('status', '!=', 'maintenance')->get();
        
        // Check for rooms that are occupied by ongoing events
        $rooms = $rooms->map(function ($room) use ($event) {
            // Find any scheduled events that are currently using this room (excluding the current event)
            $hasOngoingEvent = Event::where('room_id', $room->id)
                ->where('id', '!=', $event->id) // Exclude current event
                ->where('status', '!=', 'completed')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereDate('start_time', '<=', now())
                          ->whereDate('end_time', '>=', now());
                    });
                })
                ->exists();
            
            // If room has an ongoing event, mark it as occupied
            if ($hasOngoingEvent && $room->status === 'available') {
                $room->status = 'occupied';
            }
            
            return $room;
        });
        
        return Inertia::render('Events/Edit', [
            'event' => $event,
            'rooms' => $rooms
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'event_type' => 'required|string|max:255',
            'status' => 'required|string|in:scheduled,cancelled,completed',
            'priest_name' => 'nullable|string|max:255',
            'activities' => 'nullable|string',
            'room_id' => 'nullable|exists:rooms,id',
        ]);

        // Store the old room ID and status before updating
        $oldRoomId = $event->room_id;
        $oldStatus = $event->status;

        $event->update($validated);

        // Handle room status changes
        
        // If the event was completed, make the old room available again
        if ($oldRoomId && $event->status === 'completed') {
            $oldRoom = Room::find($oldRoomId);
            if ($oldRoom && $oldRoom->status === 'occupied') {
                // Check if there are other ongoing events for this room
                $hasOtherEvents = Event::where('room_id', $oldRoomId)
                    ->where('id', '!=', $event->id)
                    ->where('status', '!=', 'completed')
                    ->exists();
                
                if (!$hasOtherEvents) {
                    $oldRoom->status = 'available';
                    $oldRoom->save();
                }
            }
        }
        
        // If room was changed or newly assigned and event is not completed
        if ($event->room_id && $event->room_id !== $oldRoomId && $event->status !== 'completed') {
            $newRoom = Room::find($event->room_id);
            if ($newRoom && $newRoom->status === 'available') {
                $newRoom->status = 'occupied';
                $newRoom->save();
            }
        }

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // If the event has a room and is not completed, check if we need to update room status
        if ($event->room_id && $event->status !== 'completed') {
            $room = Room::find($event->room_id);
            if ($room && $room->status === 'occupied') {
                // Check if there are other ongoing events for this room
                $hasOtherEvents = Event::where('room_id', $event->room_id)
                    ->where('id', '!=', $event->id)
                    ->where('status', '!=', 'completed')
                    ->exists();
                
                if (!$hasOtherEvents) {
                    $room->status = 'available';
                    $room->save();
                }
            }
        }
        
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }
    
    /**
     * Display events in calendar format.
     */
    public function calendar()
    {
        $events = Event::all();
        
        return Inertia::render('Events/Calendar', [
            'events' => $events
        ]);
    }
}
