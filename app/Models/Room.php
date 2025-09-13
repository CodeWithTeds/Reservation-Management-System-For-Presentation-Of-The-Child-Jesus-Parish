<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'capacity',
        'status',
    ];

    /**
     * Get the events associated with the room.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Check if the room is occupied by any event.
     *
     * @return bool
     */
    public function isOccupied(): bool
    {
        return $this->status === 'occupied' || $this->events()
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) {
                $query->whereDate('start_time', '<=', now())
                    ->whereDate('end_time', '>=', now());
            })->exists();
    }
}
