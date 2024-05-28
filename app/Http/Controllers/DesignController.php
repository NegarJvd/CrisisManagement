<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDesignRequest;
use App\Http\Requests\UpdateDesignRequest;
use App\Models\Design;
use App\Models\Machine;
use App\Models\Wood;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DesignController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $designs = Design::query();

        if(!Auth::user()->is_admin)
            $designs = $designs->where('user_id', Auth::id());

        $designs = $designs->orderByDesc('id')
            ->paginate();

        return view('design.index', [
            'designs' => $designs,
        ]);
    }
    public function show($id, Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'latitude' => ['numeric','regex:/^(-)?[0-9]{1,4}+(\.[0-9]{1,15})?$/'],
            'longitude' => ['numeric','regex:/^(-)?[0-9]{1,4}+(\.[0-9]{1,15})?$/'],
        ]);

        $design = Design::findOrFail($id);

        $timber_in_range = [];
        $cnc_in_range = [];

        if ($request->has('latitude') and $request->has('longitude'))
        {
            $crisis_lat = $request->get('latitude');
            $crisis_lon = $request->get('longitude');
            $controller = new CrisisStrickenController();

            foreach ($design->timbers() as $timber)
            {
                $is_in_range = $controller->is_in_range($timber->latitude, $timber->longitude, $crisis_lat, $crisis_lon, $timber->radius);
                if ($is_in_range)
                    $timber_in_range[] = $timber;
            }
            foreach ($design->cnc() as $c)
            {
                $is_in_range = $controller->is_in_range($c->latitude, $c->longitude, $crisis_lat, $crisis_lon, $c->radius);
                if ($is_in_range)
                    $cnc_in_range[] = $c;
            }
        }

        return view('design.show', [
            'design' => $design,
            'timber_in_range' => $timber_in_range,
            'cnc_in_range' => $cnc_in_range,
            'latitude' => $request->get('latitude'),
            'longitude' => $request->get('longitude')
        ]);
    }
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $woods = Wood::all();
        $machines = Machine::all();

        return view('design.create', [
            'woods' => $woods,
            'machines' => $machines,
        ]);
    }
    public function store(StoreDesignRequest $request): RedirectResponse
    {
        $data = $request->only(['snow_load', 'wind_load', 'earthquake_load', 'number_of_households']);
        $data['user_id'] = Auth::id();
        $file = $request->file('file');
        $path = $file->store('uploads', 'public');
        $data['file_path'] = $path;

        $design = Design::create($data);
        $design->woods()->attach($request->get('woods'));
        $design->machines()->attach($request->get('machines'));

        return Redirect::to('/design')->with('status', 'success');
    }
    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $design = Design::findOrFail($id);

        if (!Auth::user()->is_admin and $design->user_id != Auth::id())
            return Redirect::to('/design')->with('status', 'error'); //You are not allowed to edit this design

        $woods = Wood::all();
        $machines = Machine::all();

        return view('design.update', [
            'woods' => $woods,
            'machines' => $machines,
            'design' => $design
        ]);
    }
    public function update(UpdateDesignRequest $request, $id): RedirectResponse
    {
        $design = Design::findOrFail($id);

        if (!Auth::user()->is_admin and $design->user_id != Auth::id())
            return Redirect::to('/designs')->with('error', 'You are not allowed to edit this design');

        $data = $request->only(['snow_load', 'wind_load', 'earthquake_load', 'number_of_households']);

        if ($request->has('file'))
        {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');
            $data['file_path'] = $path;
        }

        $design->update($data);
        $design->woods()->sync($request->get('woods'));
        $design->machines()->sync($request->get('machines'));

        return Redirect::to('design/'.$id.'/edit')->with('status', 'success');
    }
    public function destroy($id): RedirectResponse
    {
        $design = Design::findOrFail($id);

        if (!Auth::user()->is_admin and $design->user_id != Auth::id())
            return Redirect::to('/design')->with('status', 'error');

        $design->woods()->sync([]);
        $design->machines()->sync([]);

        if ($design->file_path)
        {
            $path = public_path('storage/'.$design->file_path);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $design->delete();

        return Redirect::to('/design')->with('status', 'success');
    }

    public function delete_file($design_id): RedirectResponse
    {
        $design = Design::findOrFail($design_id);

        if (Auth::user()->is_admin or $design->user_id == Auth::id())
        {
            if (Storage::exists($design->file_path))
                Storage::delete($design->file_path);

            $design->update([
                'file_path' => null
            ]);

            return Redirect::back()->with('status', 'success');
        }

        return Redirect::back()->with('status', 'error');
    }

    public function download_file($design_id): StreamedResponse|RedirectResponse
    {
        $design = Design::findOrFail($design_id);

        if (Auth::user()->is_admin or $design->user_id == Auth::id())
        {
            return Storage::download($design->file_path);
        }

        return Redirect::back()->with('status', 'error');
    }
}
