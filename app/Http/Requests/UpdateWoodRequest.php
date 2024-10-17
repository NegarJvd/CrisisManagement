<?php

namespace App\Http\Requests;

use App\Enums\WoodTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWoodRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('wood_management');
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('wood', 'name')->ignore($id)],
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
            'dtl_e' => ['required', 'numeric'],
            'dtl_g' => ['required', 'numeric'],
            'dtl_s' => ['required', 'numeric'],
            'dtl_v' => ['required', 'numeric'],
        ];
    }
}
