<?php

namespace App\Http\Requests;

use App\Models\Machine;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCNCSupplyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'machines' => ['required', 'array'],
            'machines.*' => [Rule::in(Machine::pluck('id'))],
            'radius' => ['required', 'numeric'],
            'latitude' => ['required', 'numeric','regex:/^(-)?[0-9]{1,4}+(\.[0-9]{1,15})?$/'],
            'longitude' => ['required', 'numeric','regex:/^(-)?[0-9]{1,4}+(\.[0-9]{1,15})?$/'],
        ];
    }
}
