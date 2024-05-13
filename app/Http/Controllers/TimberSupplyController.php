<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimberSupplyRequest;
use App\Http\Requests\UpdateTimberSupplyRequest;
use App\Models\TimberSupply;
use App\Models\Wood;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TimberSupplyController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $timbers = TimberSupply::query();

        if(!Auth::user()->is_admin)
            $timbers = $timbers->where('user_id', Auth::id());

        $timbers = $timbers->orderByDesc('id')
            ->paginate();

        return view('timber_supply.index', [
            'timbers' => $timbers,
        ]);
    }
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $woods = Wood::all();

        return view('timber_supply.create', [
            'woods' => $woods,
        ]);
    }
    public function store(StoreTimberSupplyRequest $request): RedirectResponse
    {
        $data = $request->only(['radius', 'latitude', 'longitude']);
        $data['user_id'] = Auth::id();

        $timber = TimberSupply::create($data);
        $timber->woods()->attach($request->get('woods'));

        return Redirect::to('/timber-supply')->with('status', 'success');
    }
    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $timber = TimberSupply::findOrFail($id);

        if (!Auth::user()->is_admin and $timber->user_id != Auth::id())
            return Redirect::to('/timber-supply')->with('status', 'error'); //You are not allowed to edit this design

        $woods = Wood::all();

        return view('timber_supply.update', [
            'woods' => $woods,
            'timber' => $timber
        ]);
    }
    public function update(UpdateTimberSupplyRequest $request, $id): RedirectResponse
    {
        $timber = TimberSupply::findOrFail($id);

        if (!Auth::user()->is_admin and $timber->user_id != Auth::id())
            return Redirect::to('/timber-supply')->with('status', 'error');

        $data = $request->only(['radius', 'latitude', 'longitude']);

        $timber->update($data);
        $timber->woods()->sync($request->get('woods'));

        return Redirect::to('timber-supply/'.$id.'/edit')->with('status', 'success');
    }
    public function destroy($id): RedirectResponse
    {
        $timber = TimberSupply::findOrFail($id);

        if (!Auth::user()->is_admin and $timber->user_id != Auth::id())
            return Redirect::to('/timber-supply')->with('status', 'error');

        $timber->woods()->sync([]);

        $timber->delete();

        return Redirect::to('/timber-supply')->with('status', 'success');
    }
}
