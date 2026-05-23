<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'vehicle_id', 'driver_id',
        'start_date', 'end_date', 'pickup_time',
        'pickup_location', 'dropoff_location', 'destination',
        'total_KiloMeter', 'total_amount', 'status', 'special_requests',
    ];

    protected $casts = [
        'start_date'   => 'date',
        'end_date'     => 'date',
        'pickup_time'  => 'datetime:H:i',
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // Fixed Total Days Accessor
    public function getTotalDaysAttribute()
    {
        $start = Carbon::parse($this->start_date);
        $end   = Carbon::parse($this->end_date);

        return $start->diffInDays($end) + 1;
    }
}