<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Room;

class Event extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'location',
        'start_time',
        'end_time',
        'event_type',
        'status',
        'created_by',
        'priest_name',
        'activities',
        'room_id',
    ];
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updated(function ($event) {
            // If the event status was changed to completed or cancelled
            if ($event->isDirty('status') && 
                ($event->status === 'completed' || $event->status === 'cancelled') && 
                $event->room_id) {
                
                // Update the room status if needed
                $room = Room::find($event->room_id);
                if ($room && $room->status === 'occupied') {
                    // Check if there are other ongoing events for this room
                    $hasOtherEvents = self::where('room_id', $event->room_id)
                        ->where('id', '!=', $event->id)
                        ->where('status', '!=', 'completed')
                        ->where('status', '!=', 'cancelled')
                        ->exists();

                    if (!$hasOtherEvents) {
                        $room->status = 'available';
                        $room->save();
                    }
                }
            }
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the user that created the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the room associated with the event.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
