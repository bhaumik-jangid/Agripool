<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateDriverProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isDriver();
    }

    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:255', 'min:2'],
            'phone'            => [
                'required',
                'string',
                'regex:/^[6-9]\d{9}$/',
            ],
            'license_number'   => [
                'required',
                'string',
                'max:50',
                'min:5',
            ],
            'license_expiry'   => [
                'required',
                'string',
                'regex:/^\d{4}-\d{2}-\d{2}$/',
            ],
            'current_location' => ['nullable', 'string', 'max:255'],
            'district'         => ['nullable', 'string', 'max:100'],
            'state'            => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex'          => 'Phone must be a valid 10-digit Indian mobile number.',
            'license_expiry.regex' => 'License expiry must be in YYYY-MM-DD format.',
            'license_number.min'   => 'License number must be at least 5 characters.',
        ];
    }
}