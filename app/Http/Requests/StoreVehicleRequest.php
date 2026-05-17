<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isDriver();
    }

    public function rules(): array
    {
        return [
            'vehicle_type'     => ['required', 'string', 'max:100'],
            'vehicle_number'   => [
                'required',
                'string',
                'max:20',
                'unique:vehicles,vehicle_number',
                'regex:/^[A-Z]{2}\d{2}[A-Z]{1,2}\d{4}$/',
            ],
            'vehicle_model'    => ['nullable', 'string', 'max:100'],
            'capacity_tonnes'  => [
                'required',
                'numeric',
                'min:0.5',
                'max:30',
            ],
            'manufacture_year' => [
                'nullable',
                'integer',
                'min:2000',
                'max:' . date('Y'),
            ],
            'insurance_number' => ['nullable', 'string', 'max:100'],
            'insurance_expiry' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_number.unique'  => 'This vehicle is already registered.',
            'vehicle_number.regex'   => 'Vehicle number format should be like GJ01AB1234.',
            'capacity_tonnes.min'    => 'Capacity must be at least 0.5 tonnes.',
            'capacity_tonnes.max'    => 'Capacity cannot exceed 30 tonnes.',
            'manufacture_year.min'   => 'Vehicle must be manufactured in 2000 or later.',
        ];
    }
}