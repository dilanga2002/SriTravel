<?php

namespace App\Http\Controllers\Traits;

use App\Models\Booking;

trait HandlesAvailability
{
    public function isVehicleAvailable($vehicleId, $startDate, $endDate, $excludeBookingId = null)
    {
        $query = Booking::where('vehicle_id', $vehicleId)
                        ->where('status', '!=', 'cancelled')
                        ->where(function ($q) use ($startDate, $endDate) {
                            $q->whereBetween('start_date', [$startDate, $endDate])
                              ->orWhereBetween('end_date', [$startDate, $endDate])
                              ->orWhere(function ($q) use ($startDate, $endDate) {
                                  $q->where('start_date', '<=', $startDate)
                                    ->where('end_date', '>=', $endDate);
                              });
                        });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->count() === 0;
    }

    public function isDriverAvailable($driverId, $startDate, $endDate, $excludeBookingId = null)
    {
        $query = Booking::where('driver_id', $driverId)
                        ->where('status', '!=', 'cancelled')
                        ->where(function ($q) use ($startDate, $endDate) {
                            $q->whereBetween('start_date', [$startDate, $endDate])
                              ->orWhereBetween('end_date', [$startDate, $endDate])
                              ->orWhere(function ($q) use ($startDate, $endDate) {
                                  $q->where('start_date', '<=', $startDate)
                                    ->where('end_date', '>=', $endDate);
                              });
                        });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->count() === 0;
    }
}