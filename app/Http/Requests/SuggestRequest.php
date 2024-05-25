<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SuggestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'latitude' => ['required', 'numeric','regex:/^(-)?[0-9]{1,4}+(\.[0-9]{1,15})?$/'],
            'longitude' => ['required', 'numeric','regex:/^(-)?[0-9]{1,4}+(\.[0-9]{1,15})?$/'],
            'number_of_households' => ['required', 'numeric', 'min:1', 'max:100'],
        ];
    }
}
