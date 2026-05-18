<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTransportRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isFarmer();
    }

    public function rules(): array
    {
        return [
            'crop_type' => [
                'required',
                'string',
                'max:100',
            ],
            'quantity_kg' => [
                'required',
                'numeric',
                'min:1',
                'max:5000',
            ],
            'packaging_type' => [
                'required',
                'string',
                'max:100',
            ],
            'pickup_location' => [
                'required',
                'string',
                'max:255',
                'min:3',
            ],
            'pickup_state' => [
                'required',
                'string',
                'max:100',
            ],
            'pickup_district' => [
                'required',
                'string',
                'max:100',
            ],
            'destination_market' => [
                'required',
                'string',
                'max:255',
                'min:3',
            ],
            'destination_state' => [
                'required',
                'string',
                'max:100',
            ],
            'destination_district' => [
                'required',
                'string',
                'max:100',
            ],
            'preferred_pickup_date' => [
                'required',
                'date',
                'after:today',
            ],
            'preferred_pickup_time' => [
                'nullable',
                'string',
            ],
            'special_instructions' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'crop_type.required'              => 'Please select a crop type.',
            'quantity_kg.required'            => 'Please enter the quantity.',
            'quantity_kg.min'                 => 'Quantity must be at least 1 kg.',
            'quantity_kg.max'                 => 'Quantity cannot exceed 5,000 kg (one truck capacity).',
            'packaging_type.required'         => 'Please select a packaging type.',
            'pickup_location.required'        => 'Please enter your pickup location.',
            'pickup_location.min'             => 'Pickup location must be at least 3 characters.',
            'pickup_state.required'           => 'Please select a pickup state.',
            'pickup_district.required'        => 'Please select a pickup district.',
            'destination_market.required'     => 'Please enter the destination market name.',
            'destination_market.min'          => 'Market name must be at least 3 characters.',
            'destination_state.required'      => 'Please select a destination state.',
            'destination_district.required'   => 'Please select a destination district.',
            'preferred_pickup_date.required'  => 'Please select a pickup date.',
            'preferred_pickup_date.after'     => 'Pickup date must be a future date.',
        ];
    }

    // // Run after validation passes
    // protected function passedValidation(): void
    // {
    //     // Convert 12-hour time to 24-hour for MySQL
    //     if ($this->preferred_pickup_time) {
    //         $this->merge([
    //             'preferred_pickup_time' => date(
    //                 'H:i:s',
    //                 strtotime($this->preferred_pickup_time)
    //             ),
    //         ]);
    //     }
    // }
}