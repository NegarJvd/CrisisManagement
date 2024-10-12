<?php

namespace App\Http\Requests;

use App\Enums\WoodTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWoodRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:wood,name'],
            'type' => ['required', Rule::in(WoodTypeEnum::values())],
            'bending_strength' => ['required', 'numeric'],
            'tension_parallel' => ['required', 'numeric'],
            'tension_perpendicular' => ['required', 'numeric'],
            'compression_parallel' => ['required', 'numeric'],
            'compression_perpendicular' => ['required', 'numeric'],
            'shear_strength' => ['required', 'numeric'],
            'e_modulus' => ['required', 'numeric'],
            'partial_factor' => ['required', 'numeric'],
            'density' => ['required', 'numeric'],
            'e_modulus_5' => ['required', 'numeric'],
            'modification_factor_permanent_term' => ['required', 'numeric'],
            'modification_factor_medium_term' => ['required', 'numeric'],
            'modification_factor_instantaneous_term' => ['required', 'numeric'],
            'creep_factor' => ['required', 'numeric'],
            'creep_factor_solid_timber' => ['required', 'numeric'],
        ];
    }
}
