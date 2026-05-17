<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTransportRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isFarmer();
    }

    public function rules(): array
    {
        return [
            'crop_type'            => ['required', 'string', 'max:100'],
            'quantity_kg'          => ['required', 'numeric', 'min:1', 'max:5000'],
            'packaging_type'       => ['required', 'string', 'max:100'],
            'pickup_location'      => ['required', 'string', 'max:255', 'min:3'],
            'pickup_state'         => ['required', 'string', 'max:100'],
            'pickup_district'      => ['required', 'string', 'max:100'],
            'destination_market'   => ['required', 'string', 'max:255'],
            'destination_state'    => ['required', 'string', 'max:100'],
            'destination_district' => ['required', 'string', 'max:100'],
            'preferred_pickup_date'=> ['required', 'date'],
            'preferred_pickup_time'=> ['nullable', 'string'],
            'special_instructions' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'quantity_kg.max'
                => 'Quantity cannot exceed 5,000 kg.',
            'preferred_pickup_date.required'
                => 'Please select a pickup date.',
        ];
    }

    protected function passedValidation(): void
    {
        if ($this->preferred_pickup_time) {
            $this->merge([
                'preferred_pickup_time' => date(
                    'H:i:s',
                    strtotime($this->preferred_pickup_time)
                ),
            ]);
        }
    }
}