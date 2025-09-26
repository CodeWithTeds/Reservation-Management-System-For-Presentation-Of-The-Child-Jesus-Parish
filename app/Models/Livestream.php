<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livestream extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'title',
        'url',
        'is_live',
        'scheduled_at',
    ];
}