<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
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
            'make'                => 'required|string|min:2|max:255',
            'model'               => 'required|string|min:2|max:255',
            'year'                => 'required|integer|min:1900|max:2025',
            'registration_number' => [
                'required',
                'string',
                'max:255',
                'unique:vehicles,registration_number',
                'regex:/^(?:[A-Z]{2}\s[A-Z]{2,3}\s\d{4}|[A-Z]{2,3}[ -]?\d{2,4}|\d{2,3}-\d{4})$/i'
            ],
            'type'                => 'required|in:car,cab,van,minibus,bus',
            'price_per_km'        => 'required|numeric|min:0|max:9999.99',
            'passengers'          => 'required|integer|min:1|max:50',
            'description'         => 'nullable|string|max:1000',
            'image'               => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'features'            => 'nullable|string|max:255',
            'available'           => 'nullable|boolean',
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'make.required'                => 'Please enter the vehicle make.',
            'make.min'                     => 'The make must be at least 2 characters.',
            'model.required'               => 'Please enter the vehicle model.',
            'model.min'                    => 'The model must be at least 2 characters.',
            'year.required'                => 'Please enter the manufacturing year.',
            'year.min'                     => 'The year must be between 1900 and 2025.',
            'year.max'                     => 'The year must be between 1900 and 2025.',
            'registration_number.required' => 'Please enter the registration number.',
            'registration_number.unique'   => 'This registration number is already in use.',
            'registration_number.regex'    => 'The registration number must be in a valid Sri Lankan format (e.g., WP CAA 3214, WP QL 9904, WP 1234, WP-1234, 12-3456).',
            'type.required'                => 'Please select a vehicle type.',
            'price_per_km.required'        => 'Please enter the price per kilometer.',
            'price_per_km.min'             => 'The price per kilometer must be at least 0.',
            'price_per_km.max'             => 'The price per kilometer cannot exceed 9999.99.',
            'passengers.required'          => 'Please enter the passenger capacity.',
            'passengers.min'               => 'The passenger capacity must be at least 1.',
            'passengers.max'               => 'The passenger capacity cannot exceed 50.',
            'image.mimes'                  => 'The image must be a PNG, JPG, or JPEG file.',
            'image.max'                    => 'The image size must not exceed 5MB.',
        ];
    }
}