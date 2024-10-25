<?php

namespace App\Http\Requests;

use App\Models\CNCSupply;
use App\Models\Design;
use App\Models\TimberSupply;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'design_id' => ['required', Rule::in(Design::pluck('id'))],
            'timber_id' => ['nullable', Rule::in(TimberSupply::pluck('id')), 'required_without:cnc_id'],
            'cnc_id' => ['nullable', Rule::in(CNCSupply::pluck('id')), 'required_without:timber_id'],
        ];
    }
}
