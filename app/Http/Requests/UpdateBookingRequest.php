<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'start_date'       => 'required|date|after_or_equal:today',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'pickup_time'      => 'required|string',
            'pickup_location'  => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'destination'      => 'required|string|max:255',
            'total_KiloMeter'  => 'required|integer|min:1',
            'driver_id'        => 'nullable|exists:users,id,role,driver,status,active',
            'special_requests' => 'nullable|string|max:500',
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'start_date.after_or_equal' => 'The start date cannot be in the past.',
            'end_date.after_or_equal'   => 'The end date must be on or after the start date.',
            'pickup_time.required'      => 'Please specify a pickup time.',
            'pickup_location.required'  => 'Please enter a pickup location.',
            'dropoff_location.required' => 'Please enter a drop-off location.',
            'destination.required'      => 'Please enter a destination.',
            'total_KiloMeter.min'       => 'Total kilometers must be at least 1.',
            'driver_id.exists'          => 'The selected driver is invalid or not active.',
        ];
    }
}