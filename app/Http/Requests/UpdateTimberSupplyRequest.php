<?php

namespace App\Http\Requests;

use App\Models\Machine;
use App\Models\Wood;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTimberSupplyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'woods' => ['required', 'array'],
            'woods.*' => [Rule::in(Wood::pluck('id'))],
            'radius' => ['required', 'numeric'],
            'latitude' => ['required', 'numeric','regex:/^(-)?[0-9]{1,4}+(\.[0-9]{1,15})?$/'],
            'longitude' => ['required', 'numeric','regex:/^(-)?[0-9]{1,4}+(\.[0-9]{1,15})?$/'],
        ];
    }
}
