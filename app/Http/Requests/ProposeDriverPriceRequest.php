<?php

namespace App\Http\Requests;

use App\Models\Pool;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProposeDriverPriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isDriver();
    }

    public function rules(): array
    {
        $pool = $this->route('pool');

        return [
            'proposed_cost' => [
                'required',
                'numeric',
                'min:' . (($pool->total_cost ?? 0) * 1.01),
                'max:' . (($pool->total_cost ?? 0) * 3),
            ],
            'reason' => [
                'required',
                'string',
                'min:20',
                'max:500',
            ],
        ];
    }

    public function messages(): array
    {
        $pool     = $this->route('pool');
        $original = number_format($pool->total_cost ?? 0, 0);

        return [
            'proposed_cost.min'
                => "Proposed price must be higher than the original ₹{$original}.",
            'proposed_cost.max'
                => "Proposed price cannot exceed 3× the original price (₹{$original}).",
            'reason.min'
                => 'Please provide a reason of at least 20 characters.',
            'reason.max'
                => 'Reason cannot exceed 500 characters.',
        ];
    }
}