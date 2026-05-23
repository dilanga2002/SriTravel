<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'make',
        'model',
        'year',
        'registration_number',
        'type',
        'price_per_km', // Changed from price_per_day
        'description',
        'image',
        'available',
        'passengers',
        'features'
    ];

    protected $casts = [
        'available' => 'boolean',
        'features' => 'array', // Cast features as an array
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}