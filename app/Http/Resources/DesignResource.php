<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $wood = $this->woods[0];
        return [
            'id' => $this->id,
            'material' => [
                'name' => $wood->name,
                'partial_factor' => $wood->partial_factor,
                'density' => $wood->density,
                'bending_strength' => $wood->bending_strength,
                'shear_strength' => $wood->shear_strength,
                'compression_parallel' => $wood->compression_parallel,
                'e_modulus' => $wood->e_modulus,
                'e_modulus_5' => $wood->e_modulus_5,
                'modification_factor_permanent_term' => $wood->modification_factor_permanent_term,
                'modification_factor_medium_term' => $wood->modification_factor_medium_term,
                'modification_factor_instantaneous_term' => $wood->modification_factor_instantaneous_term,
                'creep_factor' => $wood->creep_factor,
                'creep_factor_solid_timber' => $wood->creep_factor_solid_timber
            ],
            'cross_section' => [
                'beam_w' => $this->beam_w,
                'beam_h' => $this->beam_h
            ],
            'footprint' => [
                'length' => $this->length,
                'column_number' => $this->column_number,
                'height' => $this->height,
                'slab_thickness' => $this->slab_thickness,
                'width' => $this->width
            ],
            'user' => [
                'name' => $this->user->name
            ]
        ];
    }
}
