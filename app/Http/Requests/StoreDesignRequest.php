<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDesignRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file'],
            'snow_load' => ['required', 'numeric'],
            'wind_load' => ['required', 'numeric'],
            'earthquake_load' => ['required', 'numeric'],
            'number_of_households' => ['required', 'min:1', 'max:100']
        ];
    }
}
