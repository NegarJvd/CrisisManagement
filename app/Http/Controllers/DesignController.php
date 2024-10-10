<?php

namespace App\Http\Controllers;

use App\Enums\JointTypeEnum;
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
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DesignController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $designs = Design::query()
            ->orderByDesc('id')
            ->paginate();

        return view('design.index', [
            'designs' => $designs,
        ]);
    }
    public function show($id, Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'latitude' => ['numeric'],
            'longitude' => ['numeric'],
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

    public function create_step_1(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');

        return view('design.create.step1', compact('design', 'woods'));
    }

    public function store_step_1(Request $request): RedirectResponse
    {
        $request->validate([
            'woods' => ['required', Rule::in(Wood::pluck('id'))],
        ]);

        if(empty($request->session()->get('woods'))){
            $design = new Design();
        }else{
            $design = $request->session()->get('design');
        }

        $request->session()->put('design', $design);
        $request->session()->put('woods', $request->get('woods'));

        return Redirect::to('/design/create/step2')->with('status', 'success');
    }

    public function create_step_2(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');

        return view('design.create.step2', compact('design', 'woods'));
    }

    public function store_step_2(Request $request): RedirectResponse
    {
        $request->validate([
            'width' => ['required', 'numeric', 'min:0'],
            'length' => ['required', 'numeric', 'min:0'],
            'height' => ['required', 'numeric', 'min:0'],
            'column_number' => ['required', 'numeric', 'min:0'],
        ]);

        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');

        $input = $request->only(['width', 'length', 'height', 'column_number']);
        $design->fill($input);

        $request->session()->put('design', $design);
        $request->session()->put('woods', $woods);

        return Redirect::to('/design/create/step3')->with('status', 'success');
    }

    public function create_step_3(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');

        return view('design.create.step3',
            compact('design', 'woods'));
    }

    public function store_step_3(Request $request): RedirectResponse
    {
        $request->validate([
            'snow_load' => ['required', 'numeric', 'min:0'],
            'wind_load' => ['required', 'numeric', 'min:0'],
            'dead_load' => ['required', 'numeric', 'min:0'],
            'live_load' => ['required', 'numeric', 'min:0'],
        ]);

        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');

        $request->session()->put('design', $design);
        $request->session()->put('woods', $woods);

        return Redirect::to('/design/create/step4')->with('status', 'success');
    }

    public function create_step_4(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');

        return view('design.create.step4',
            compact('design', 'woods'));
    }

    public function store_step_4(Request $request): RedirectResponse
    {
        $request->validate([
            'beam_w' => ['required', 'numeric', 'min:0'],
            'beam_h' => ['required', 'numeric', 'min:0'],
            'column_w' => ['required', 'numeric', 'min:0'],
            'column_h' => ['required', 'numeric', 'min:0'],
            'top_plate_w' => ['required', 'numeric', 'min:0'],
            'top_plate_h' => ['required', 'numeric', 'min:0'],
            'long_sill_w' => ['required', 'numeric', 'min:0'],
            'long_sill_h' => ['required', 'numeric', 'min:0'],
        ]);

        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');

        $input = $request->only(['beam_w', 'beam_h', 'column_w', 'column_h', 'top_plate_w', 'top_plate_h', 'long_sill_w', 'long_sill_h']);
        $design->fill($input);

        $request->session()->put('design', $design);
        $request->session()->put('woods', $woods);

        return Redirect::to('/design/create/step5')->with('status', 'success');
    }

    public function create_step_5(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');

        return view('design.create.step5',
            compact('design', 'woods'));
    }

    public function store_step_5(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'joint1' => ['required', Rule::in(JointTypeEnum::values())],
            'joint2' => ['required', Rule::in(JointTypeEnum::values())],
            'joint3' => ['required', Rule::in(JointTypeEnum::values())],
            'joint4' => ['required', Rule::in(JointTypeEnum::values())],
            'joint1_dtl_clm' => ['required','numeric'],
        ]);

        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');

        $input = $request->only(['joint1', 'joint2', 'joint3', 'joint4',
            'joint1_dtl_clm', 'joint1_dtj_clm', 'joint1_btl_clm', 'joint1_ttl_clm', 'joint1_b_clm',
            'joint2_jc1', 'joint2_jc2', 'joint2_jc3', 'joint2_jc4', 'joint2_jc5', 'joint2_jc6', 'joint2_jc7',
            'joint3_lim_e', 'joint3_lim_s', 'joint3_lim_v', 'joint3_lim_g', 'joint3_lim_t', 'joint3_wtb',
            'joint3_wt', 'joint3_tt', 'joint3_s2_clm',
            'joint4_btucl', 'joint4_ttu_clm', 'joint4_gu_sb', 'joint4_esb', 'joint4_leu_sb', 'joint4_lsus',
            'joint4_glsb', 'joint4_lsb', 'joint4_tb', 'joint4_wb'

        ]);
        $design->fill($input);
        $design->user_id = Auth::id();
        $design->save();

        $design->woods()->attach($woods);

        $request->session()->forget('design');
        $request->session()->forget('woods');

        return view('design.create.final_result');
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
        $data = $request->only(['snow_load', 'wind_load', 'earthquake_load', 'number_of_households', 'fork_id']);
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

    public function fork($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = Design::findOrFail($id);

        $woods = Wood::all();
        $machines = Machine::all();

        return view('design.update', [
            'woods' => $woods,
            'machines' => $machines,
            'design' => $design,
            'fork' => 1
        ]);
    }
}
