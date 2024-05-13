<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCNCSupplyRequest;
use App\Http\Requests\UpdateCNCSupplyRequest;
use App\Models\CNCSupply;
use App\Models\Machine;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CNCSupplyController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cnc_supplies = CNCSupply::query();

        if (!Auth::user()->is_admin)
            $cnc_supplies = $cnc_supplies->where('user_id', Auth::id());

        $cnc_supplies = $cnc_supplies->orderByDesc('id')
            ->paginate();

        return view('cnc_supply.index', [
            'cnc_supplies' => $cnc_supplies,
        ]);
    }
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $machines = Machine::all();

        return view('cnc_supply.create', [
            'machines' => $machines,
        ]);
    }
    public function store(StoreCNCSupplyRequest $request): RedirectResponse
    {
        $data = $request->only(['radius', 'latitude', 'longitude']);
        $data['user_id'] = Auth::id();

        $cnc = CNCSupply::create($data);
        $cnc->machines()->attach($request->get('machines'));

        return Redirect::to('/cnc-supply')->with('status', 'success');
    }
    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $cnc = CNCSupply::findOrFail($id);

        if (!Auth::user()->is_admin and $cnc->user_id != Auth::id())
            return Redirect::to('/cnc-supply')->with('status', 'error'); //You are not allowed to edit this design

        $machines = Machine::all();

        return view('cnc_supply.update', [
            'machines' => $machines,
            'cnc' => $cnc
        ]);
    }
    public function update(UpdateCNCSupplyRequest $request, $id): RedirectResponse
    {
        $cnc = CNCSupply::findOrFail($id);

        if (!Auth::user()->is_admin and $cnc->user_id != Auth::id())
            return Redirect::to('/cnc-supply')->with('status', 'error');

        $data = $request->only(['radius', 'latitude', 'longitude']);

        $cnc->update($data);
        $cnc->machines()->sync($request->get('machines'));

        return Redirect::to('cnc-supply/'.$id.'/edit')->with('status', 'success');
    }
    public function destroy($id): RedirectResponse
    {
        $cnc = CNCSupply::findOrFail($id);

        if (!Auth::user()->is_admin and $cnc->user_id != Auth::id())
            return Redirect::to('/cnc-supply')->with('status', 'error');

        $cnc->machines()->sync([]);

        $cnc->delete();

        return Redirect::to('/cnc-supply')->with('status', 'success');
    }
}
