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
        $id = $this->route('id');
        return [
            'name' => ['required', 'string', 'max:255', 'unique:wood,name,'.$id],
            'type' => ['required', Rule::in(WoodTypeEnum::values())]
        ];
    }
}
