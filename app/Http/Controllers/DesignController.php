<?php

namespace App\Http\Controllers;

use App\Enums\JointTypeEnum;
use App\Http\Requests\DesignFilterRequest;
use App\Models\Design;
use App\Models\Wood;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class DesignController extends Controller
{
    public function index(DesignFilterRequest $request): \Illuminate\Contracts\Foundation\Application|Factory|View|Application|JsonResponse
    {
        $width_min = $request->get('width_min');
        $length_min = $request->get('length_min');
        $height_min = $request->get('height_min');
        $width_max = $request->get('width_max');
        $length_max = $request->get('length_max');
        $height_max = $request->get('height_max');

        $designs = Design::query()
                    ->with('user', function ($q){
                        $q->select('id','name');
                    })
                    ->with('woods');

        if (!is_null($width_min) and !is_null($width_max))
        {
            $designs = $designs->whereBetween('width', [$width_min, $width_max]);
        }
        if (!is_null($length_max) and !is_null($length_min))
        {
            $designs = $designs->whereBetween('length', [$length_min, $length_max]);
        }
        if (!is_null($height_max) and !is_null($height_min))
        {
            $designs = $designs->whereBetween('height', [$height_min, $height_max]);
        }

        $designs =  $designs->orderByDesc('id')
            ->paginate();

        if ($request->wantsJson()){
            return response()->json($designs);
        }

        return view('design.index', [
            'designs' => $designs,
        ]);
    }
    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = Design::findOrFail($id);
        $wood = $design->woods()->get();


        return view('design.show', [
            'design' => $design,
            'wood' => $wood[0]
        ]);
    }
    public function create_step_1(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');
        $wood_model = $request->session()->get('wood_model');
        $snow_load = $request->session()->get('snow_load') ?? 0;
        $wind_load = $request->session()->get('wind_load') ?? 0;
        $dead_load = $request->session()->get('dead_load') ?? 0;
        $live_load = $request->session()->get('live_load') ?? 0;
        $load_calculator_values_as_object = $request->session()->get('load_calculator_values_as_object') ?? "";
        $load_calculator_values_as_string = $request->session()->get('load_calculator_values_as_string') ?? "";
        $cross_section_optimization_as_string = $request->session()->get('cross_section_optimization_as_string') ?? "";
        $joint_details_as_string = $request->session()->get('joint_details_as_string') ?? "";

        return view('design.create.step1', compact('design', 'woods', 'wood_model',
                                                        'snow_load', 'wind_load', 'dead_load', 'live_load',
                                                        'load_calculator_values_as_string', 'load_calculator_values_as_object',
                                                        'cross_section_optimization_as_string', 'joint_details_as_string'));
    }
    public function store_step_1(Request $request): RedirectResponse
    {
        $request->validate([
            'woods' => ['required', Rule::in(Wood::pluck('id'))],
        ]);

        if(empty($request->session()->get('woods'))){
            $design = new Design();
            $wood_model = new Wood();
        }else{
            $design = $request->session()->get('design');
            $wood_model = Wood::find($request->get('woods'));
        }

        $request->session()->put('design', $design);
        $request->session()->put('woods', $request->get('woods'));
        $request->session()->put('wood_model', $wood_model);

        return Redirect::to('/design/create/step2')->with('status', 'success');
    }
    public function create_step_2(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');
        $wood_model = $request->session()->get('wood_model');
        $snow_load = $request->session()->get('snow_load') ?? 0;
        $wind_load = $request->session()->get('wind_load') ?? 0;
        $dead_load = $request->session()->get('dead_load') ?? 0;
        $live_load = $request->session()->get('live_load') ?? 0;
        $load_calculator_values_as_object = $request->session()->get('load_calculator_values_as_object') ?? "";
        $load_calculator_values_as_string = $request->session()->get('load_calculator_values_as_string') ?? "";
        $cross_section_optimization_as_string = $request->session()->get('cross_section_optimization_as_string') ?? "";
        $joint_details_as_string = $request->session()->get('joint_details_as_string') ?? "";

        return view('design.create.step2',
            compact('design', 'woods', 'wood_model', 'snow_load', 'wind_load', 'dead_load', 'live_load',
                'load_calculator_values_as_string', 'load_calculator_values_as_object',
                'cross_section_optimization_as_string', 'joint_details_as_string'));
    }
    public function store_step_2(Request $request): RedirectResponse
    {
        $request->validate([
            'width' => ['required', 'numeric', 'min:0'],
            'length' => ['required', 'numeric', 'min:0'],
            'height' => ['required', 'numeric', 'min:0'],
            'slab_thickness' => ['required', 'numeric', 'min:0'],
            'column_number' => ['required', 'numeric', 'min:0'],
        ]);

        $design = $request->session()->get('design');

        $input = $request->only(['width', 'length', 'height', 'slab_thickness', 'column_number']);
        $design->fill($input);

        $request->session()->put('design', $design);

        return Redirect::to('/design/create/step3')->with('status', 'success');
    }
    public function create_step_3(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');
        $wood_model = $request->session()->get('wood_model');
        $snow_load = $request->session()->get('snow_load') ?? 0;
        $wind_load = $request->session()->get('wind_load') ?? 0;
        $dead_load = $request->session()->get('dead_load') ?? 0;
        $live_load = $request->session()->get('live_load') ?? 0;
        $load_calculator_values_as_object = $request->session()->get('load_calculator_values_as_object') ?? "";
        $load_calculator_values_as_string = $request->session()->get('load_calculator_values_as_string') ?? "";
        $cross_section_optimization_as_string = $request->session()->get('cross_section_optimization_as_string') ?? "";
        $joint_details_as_string = $request->session()->get('joint_details_as_string') ?? "";

        return view('design.create.step3',
            compact('design', 'woods', 'wood_model', 'snow_load', 'wind_load', 'dead_load', 'live_load',
                        'load_calculator_values_as_object', 'load_calculator_values_as_string', 'cross_section_optimization_as_string',
                        'joint_details_as_string'));
    }
    public function store_step_3(Request $request): RedirectResponse
    {
        $snow_load = $request->get('snow_load') ?? 0;
        $wind_load = $request->get('wind_load') ?? 0;
        $dead_load = $request->get('dead_load') ?? 0;
        $live_load = $request->get('live_load') ?? 0;
        $load_calculator_values_as_object = $request->get('load_calculator_values_as_object');
        $load_calculator_values_as_string = $request->get('load_calculator_values_as_string');

        $request->session()->put('snow_load', $snow_load);
        $request->session()->put('wind_load', $wind_load);
        $request->session()->put('dead_load', $dead_load);
        $request->session()->put('live_load', $live_load);
        $request->session()->put('load_calculator_values_as_object', $load_calculator_values_as_object);
        $request->session()->put('load_calculator_values_as_string', $load_calculator_values_as_string);

        return Redirect::to('/design/create/step4')->with('status', 'success');
    }
    public function create_step_4(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');
        $wood_model = $request->session()->get('wood_model');
        $snow_load = $request->session()->get('snow_load') ?? 0;
        $wind_load = $request->session()->get('wind_load') ?? 0;
        $dead_load = $request->session()->get('dead_load') ?? 0;
        $live_load = $request->session()->get('live_load') ?? 0;
        $load_calculator_values_as_object = $request->session()->get('load_calculator_values_as_object') ?? "";
        $load_calculator_values_as_string = $request->session()->get('load_calculator_values_as_string') ?? "";
        $cross_section_optimization_as_string = $request->session()->get('cross_section_optimization_as_string') ?? "";
        $joint_details_as_string = $request->session()->get('joint_details_as_string') ?? "";

        return view('design.create.step4',
            compact('design', 'woods', 'wood_model', 'snow_load', 'wind_load', 'dead_load', 'live_load',
                'load_calculator_values_as_object', 'load_calculator_values_as_string', 'cross_section_optimization_as_string',
                'joint_details_as_string'));
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

        $input = $request->only(['beam_w', 'beam_h', 'column_w', 'column_h', 'top_plate_w', 'top_plate_h', 'long_sill_w', 'long_sill_h']);
        $design->fill($input);

        $request->session()->put('design', $design);
        $request->session()->put('cross_section_optimization_as_string', $request->get('cross_section_optimization_as_string'));

        return Redirect::to('/design/create/step5')->with('status', 'success');
    }
    public function create_step_5(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');
        $wood_model = $request->session()->get('wood_model');
        $snow_load = $request->session()->get('snow_load') ?? 0;
        $wind_load = $request->session()->get('wind_load') ?? 0;
        $dead_load = $request->session()->get('dead_load') ?? 0;
        $live_load = $request->session()->get('live_load') ?? 0;
        $load_calculator_values_as_object = $request->session()->get('load_calculator_values_as_object') ?? "";
        $load_calculator_values_as_string = $request->session()->get('load_calculator_values_as_string') ?? "";
        $cross_section_optimization_as_string = $request->session()->get('cross_section_optimization_as_string') ?? "";
        $joint_details_as_string = $request->session()->get('joint_details_as_string') ?? "";

        return view('design.create.step5',
            compact('design', 'woods', 'wood_model', 'snow_load', 'wind_load', 'dead_load', 'live_load',
                'load_calculator_values_as_object', 'load_calculator_values_as_string', 'cross_section_optimization_as_string',
                'joint_details_as_string'));
    }
    public function store_step_5(Request $request): RedirectResponse
    {
        $request->validate([
            'joint1' => ['required'],
            'joint2' => ['required'],
            'joint3' => ['required'],
            'joint4' => ['required'],
        ]);

        $design = $request->session()->get('design');
        $woods = $request->session()->get('woods');
        $load_calculator_values_as_string = $request->session()->get('load_calculator_values_as_string') ?? "";
        $cross_section_optimization_as_string = $request->session()->get('cross_section_optimization_as_string') ?? "";
        $joint_details_as_string = $request->get('joint_details_as_string') ?? "";

        $input = $request->only(['joint1', 'joint2', 'joint3', 'joint4',
            'joint1_dtl_clm', 'joint1_dtj_clm', 'joint1_btl_clm', 'joint1_ttl_clm', 'joint1_b_clm', 'joint1_dtt_clm',
            'joint2_jc1', 'joint2_jc2', 'joint2_jc3', 'joint2_jc4', 'joint2_jc5', 'joint2_jc6', 'joint2_jc7',
            'joint3_lim_e', 'joint3_lim_s', 'joint3_lim_v', 'joint3_lim_g', 'joint3_d',
            'joint4_btucl', 'joint4_ttu_clm', 'joint4_l_scr', 'joint4_esb', 'joint4_leu_sb', 'joint4_lsu_s_b',
            'joint4_glsb', 'joint4_tb', 'joint4_wb', 'joint4_d'
        ]);
        $design->fill($input);
        $design->user_id = Auth::id();
        $design->information = "<b> Structural details and performance: </b> <br>" . $cross_section_optimization_as_string . "<br><br>" .
                                "<b> Load details: </b> <br>" . $load_calculator_values_as_string . "<br>" .
                                "<b> Joint details: </b> <br>" . $joint_details_as_string;
        $design->save();

        $design->woods()->attach($woods);

        $request->session()->forget('design');
        $request->session()->forget('woods');
        $request->session()->forget('wood_model');
        $request->session()->forget('snow_load');
        $request->session()->forget('wind_load');
        $request->session()->forget('dead_load');
        $request->session()->forget('live_load');
        $request->session()->forget('load_calculator_values_as_string');
        $request->session()->forget('load_calculator_values_as_object');
        $request->session()->forget('cross_section_optimization_as_string');
        $request->session()->forget('joint_details_as_string');

        return Redirect::to('/design/'.$design->id)->with('status', 'success');
    }
    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $design = Design::findOrFail($id);

        if (!Auth::user()->is_admin and $design->user_id != Auth::id())
            return Redirect::to('/design')->with('status', 'error'); //You are not allowed to edit this design

        $woods = Wood::all();

        return view('design.update', [
            'woods' => $woods,
            'design' => $design
        ]);
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $design = Design::findOrFail($id);

        if (!Auth::user()->is_admin and $design->user_id != Auth::id())
            return Redirect::to('/designs')->with('error', 'You are not allowed to edit this design');

        $data = $request->all();
        $design->update($data);
        $design->woods()->sync($request->get('woods'));

        return Redirect::to('design/'.$id.'/edit')->with('status', 'success');
    }
    public function destroy($id): RedirectResponse
    {
        $design = Design::findOrFail($id);

        if (!Auth::user()->is_admin and $design->user_id != Auth::id())
            return Redirect::to('/design')->with('status', 'error');

        $design->woods()->sync([]);

        $design->delete();

        return Redirect::to('/design')->with('status', 'success');
    }

    public function fork($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $design = Design::findOrFail($id);

        $woods = Wood::all();

        return view('design.update', [
            'woods' => $woods,
            'design' => $design,
            'fork' => 1
        ]);
    }
}
