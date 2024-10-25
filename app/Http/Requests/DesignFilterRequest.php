<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DesignFilterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'width_min' => ['numeric', 'min:0'],
            'width_max' => ['numeric', 'gte:width_min'],
            'length_min' => ['numeric', 'min:0'],
            'length_max' => ['numeric', 'gte:length_min'],
            'height_min' => ['numeric', 'min:0'],
            'height_max' => ['numeric', 'gte:height_min'],
        ];
    }
}
