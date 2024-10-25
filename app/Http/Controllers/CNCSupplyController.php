<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCNCSupplyRequest;
use App\Http\Requests\UpdateCNCSupplyRequest;
use App\Models\CNCSupply;
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
        return view('cnc_supply.create');
    }
    public function store(StoreCNCSupplyRequest $request): RedirectResponse
    {
        $data = $request->only(['radius', 'latitude', 'longitude']);
        $data['user_id'] = Auth::id();

        $cnc = CNCSupply::create($data);

        return Redirect::to('/cnc-provider')->with('success', 'Stored successfully!');
    }
    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $cnc = CNCSupply::findOrFail($id);

        if (!Auth::user()->is_admin and $cnc->user_id != Auth::id())
            return Redirect::to('/cnc-supply')->with('error', 'Permission denied!');

        return view('cnc_supply.update', [
            'cnc' => $cnc
        ]);
    }
    public function update(UpdateCNCSupplyRequest $request, $id): RedirectResponse
    {
        $cnc = CNCSupply::findOrFail($id);

        if (!Auth::user()->is_admin and $cnc->user_id != Auth::id())
            return Redirect::to('/cnc-provider')->with('error', 'Permission denied!');

        $data = $request->only(['radius', 'latitude', 'longitude']);

        $cnc->update($data);

        return Redirect::to('cnc-provider/'.$id.'/edit')->with('success', 'Updated successfully!');
    }
    public function destroy($id): RedirectResponse
    {
        $cnc = CNCSupply::findOrFail($id);

        if (!Auth::user()->is_admin and $cnc->user_id != Auth::id())
            return Redirect::to('/cnc-provider')->with('error', 'Permission denied!');

        $cnc->delete();

        return Redirect::to('/cnc-provider')->with('success', 'Deleted successfully!');
    }
}
