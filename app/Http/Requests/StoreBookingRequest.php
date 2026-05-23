<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id'       => 'required|exists:vehicles,id',
            'start_date'       => 'required|date|after_or_equal:today',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'pickup_time'      => 'required|string',
            'pickup_location'  => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'destination'      => 'required|string|max:255',
            'total_KiloMeter'  => 'required|integer|min:1',
            'driver_id'        => 'nullable|exists:users,id', // Simplified
            'special_requests' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_id.exists'       => 'Selected vehicle does not exist.',
            'start_date.after_or_equal' => 'Start date cannot be in the past.',
            'end_date.after_or_equal'   => 'End date must be after or equal to start date.',
            'total_KiloMeter.min'       => 'Total kilometers must be at least 1.',
            'driver_id.exists'          => 'Selected driver is invalid.',
        ];
    }
}