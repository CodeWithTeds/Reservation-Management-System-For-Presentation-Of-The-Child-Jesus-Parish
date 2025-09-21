<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'service_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_type',
        'description',
        'capacity',
        'requirements',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'capacity' => 'integer',
    ];

    /**
     * Get the reservations associated with this service.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'service_id', 'service_id');
    }
}