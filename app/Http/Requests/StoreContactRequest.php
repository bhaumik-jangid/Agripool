<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public form
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:255', 'min:2'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.min'       => 'Name must be at least 2 characters.',
            'message.min'    => 'Message must be at least 10 characters.',
            'message.max'    => 'Message cannot exceed 2000 characters.',
            'email.email'    => 'Please enter a valid email address.',
            'subject.required'=> 'Please select a subject.',
        ];
    }
}