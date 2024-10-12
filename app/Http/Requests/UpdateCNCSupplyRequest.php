<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCNCSupplyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'radius' => ['required', 'numeric'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ];
    }
}
