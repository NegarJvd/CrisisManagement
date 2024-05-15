<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMachineRequest;
use App\Http\Requests\UpdateMachineRequest;
use App\Models\Machine;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class MachineManagementController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $machines = Machine::query()
                    ->orderByDesc('id')
                    ->paginate();

        return view('machine.index', [
            'machines' => $machines,
        ]);
    }

    public function store(StoreMachineRequest $request): RedirectResponse
    {
        $data = $request->only(['name']);

        Machine::create($data);

        return Redirect::to('/machine-management')->with('status', 'success');
    }

    public function update(UpdateMachineRequest $request, $id): RedirectResponse
    {
        $machine = Machine::findOrFail($id);

        $data = $request->only(['name']);
        $machine->update($data);

        return Redirect::to('/machine-management')->with('status', 'success');
    }

    public function destroy($id): RedirectResponse
    {
        $machine = Machine::query()
                ->withCount(['designs', 'cnc_supplies'])
                ->findOrFail($id);

        if ($machine->designs_count > 0 or $machine->cnc_supplies_count > 0)
            return Redirect::to('/machine-management')->with('status', 'error');

        $machine->delete();

        return Redirect::to('/machine-management')->with('status', 'success');
    }


}
