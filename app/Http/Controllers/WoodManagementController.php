<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWoodRequest;
use App\Http\Requests\UpdateWoodRequest;
use App\Models\Wood;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class WoodManagementController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $woods = Wood::query()
                    ->orderByDesc('id')
                    ->paginate();

        return view('wood.index', [
            'woods' => $woods,
        ]);
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('wood.create');
    }

    public function store(StoreWoodRequest $request): RedirectResponse
    {
        $data = $request->only([
            'name', 'type', 'bending_strength',
            'tension_parallel', 'tension_perpendicular',
            'compression_parallel', 'compression_perpendicular',
            'shear_strength', 'e_modulus', 'partial_factor',
            'density', 'e_modulus_5', 'modification_factor_permanent_term',
            'modification_factor_medium_term', 'modification_factor_instantaneous_term',
            'creep_factor', 'creep_factor_solid_timber', 'dtl_e', 'dtl_g', 'dtl_s', 'dtl_v'
            ]);

        Wood::create($data);

        return Redirect::to('/wood-management')->with('status', 'success');
    }

    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $wood = Wood::findOrFail($id);

        return view('wood.update', [
            'wood' => $wood
        ]);
    }

    public function update(UpdateWoodRequest $request, $id): RedirectResponse
    {
        $wood = Wood::findOrFail($id);

        $data = $request->only([
            'name', 'type', 'bending_strength',
            'tension_parallel', 'tension_perpendicular',
            'compression_parallel', 'compression_perpendicular',
            'shear_strength', 'e_modulus', 'partial_factor',
            'density', 'e_modulus_5', 'modification_factor_permanent_term',
            'modification_factor_medium_term', 'modification_factor_instantaneous_term',
            'creep_factor', 'creep_factor_solid_timber', 'dtl_e', 'dtl_g', 'dtl_s', 'dtl_v'
        ]);

        $wood->update($data);

        return Redirect::to('/wood-management')->with('status', 'success');
    }

    public function destroy($id): RedirectResponse
    {
        $wood = Wood::query()
                ->withCount(['designs', 'timber_supplies'])
                ->findOrFail($id);

        if ($wood->designs_count > 0 or $wood->timber_supplies_count > 0)
            return Redirect::to('/wood-management')->with('status', 'error');

        $wood->delete();

        return Redirect::to('/wood-management')->with('status', 'success');
    }


}
