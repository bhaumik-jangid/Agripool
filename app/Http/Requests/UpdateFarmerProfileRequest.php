<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateFarmerProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isFarmer();
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255', 'min:2'],
            'phone'         => [
                'required',
                'string',
                'regex:/^[6-9]\d{9}$/',
            ],
            'farm_name'     => ['nullable', 'string', 'max:255'],
            'farm_location' => ['required', 'string', 'max:255', 'min:3'],
            'district'      => ['required', 'string', 'max:100'],
            'state'         => ['required', 'string', 'max:100'],
            'pincode'       => [
                'nullable',
                'string',
                'regex:/^\d{6}$/',
            ],
            'bio'           => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex'   => 'Phone must be a valid 10-digit Indian mobile number.',
            'pincode.regex' => 'Pincode must be exactly 6 digits.',
            'name.min'      => 'Name must be at least 2 characters.',
        ];
    }
}