<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDriverRequest extends FormRequest
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
        $driverId = $this->route('driver'); // Get driver ID from route parameter

        return [
            'name'           => ['required', 'string', 'regex:/^[A-Za-z\s]{2,50}$/'],
            'email'          => ['required', 'email', Rule::unique('users')->ignore($driverId)],
            'phone'          => ['required', 'regex:/^(\+94|0)[0-9]{9}$/'],
            'address'        => ['nullable', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'regex:/^[A-Za-z0-9]{5,15}$/'],
            'password'       => ['nullable', 'min:8', 'confirmed'],
            'driver_photo'   => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'status'         => ['required', 'in:active,inactive'],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'name.required'           => 'Please enter the driver\'s full name.',
            'name.regex'              => 'The name should be 2-50 characters long and contain only letters and spaces.',
            
            'email.required'          => 'Please enter the driver\'s email address.',
            'email.email'             => 'Please enter a valid email address.',
            'email.unique'            => 'This email address is already in use.',
            
            'phone.required'          => 'Please enter the driver\'s phone number.',
            'phone.regex'             => 'Please enter a valid Sri Lankan phone number (e.g., 0771234567 or +94771234567).',
            
            'address.max'             => 'The address cannot be longer than 255 characters.',
            
            'license_number.required' => 'Please enter the driver\'s license number.',
            'license_number.regex'    => 'The license number should be 5-15 alphanumeric characters.',
            
            'password.min'            => 'The password must be at least 8 characters long.',
            'password.confirmed'      => 'The password confirmation does not match.',
            
            'driver_photo.image'      => 'The driver photo must be an image.',
            'driver_photo.mimes'      => 'The driver photo must be a PNG, JPG, or JPEG file.',
            'driver_photo.max'        => 'The driver photo cannot be larger than 2MB.',
            
            'status.required'         => 'Please select the driver\'s status.',
            'status.in'               => 'The status must be either active or inactive.',
        ];
    }
}