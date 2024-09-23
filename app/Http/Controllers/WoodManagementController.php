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

    public function store(StoreWoodRequest $request): RedirectResponse
    {
        $data = $request->only(['name', 'type', 'bending_strength',
            'tension_parallel', 'tension_perpendicular',
            'compression_parallel', 'compression_perpendicular',
            'shear_strength', 'e_modulus']);

        Wood::create($data);

        return Redirect::to('/wood-management')->with('status', 'success');
    }

    public function update(UpdateWoodRequest $request, $id): RedirectResponse
    {
        $wood = Wood::findOrFail($id);

        $data = $request->only(['name', 'type', 'bending_strength',
            'tension_parallel', 'tension_perpendicular',
            'compression_parallel', 'compression_perpendicular',
            'shear_strength', 'e_modulus']);

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
