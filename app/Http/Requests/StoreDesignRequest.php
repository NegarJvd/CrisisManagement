<?php

namespace App\Http\Requests;

use App\Models\Design;
use App\Models\Machine;
use App\Models\Wood;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'number_of_households' => ['required', 'numeric', 'min:1', 'max:100'],
            'woods' => ['required', 'array'],
            'woods.*' => [Rule::in(Wood::pluck('id'))],
            'machines' => ['required', 'array'],
            'machines.*' => [Rule::in(Machine::pluck('id'))],
            'fork_id' => ['nullable', Rule::in(Design::pluck('id'))]
        ];
    }
}
