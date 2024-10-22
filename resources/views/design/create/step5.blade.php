@php use App\Enums\JointTypeEnum;use App\Models\Wood; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Design') }}
        </h2>
    </x-slot>

    <script type="module">
        $(document).ready(function () {
            $('#calculator').on('click', function () {
                const url = "{!! env('FLASK_URL') !!}" + '/joint1-2-4';

                $.ajax({
                    url: url,
                    type: 'POST',
                    async: true,
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "footprint": {
                            "height": parseFloat("{{$design->height}}"),
                        },
                        "cross_section": {
                            "bottom_sill_w": parseFloat("{{$design->long_sill_w}}"),
                            "column_h": parseFloat("{{$design->column_h}}"),
                            "column_w": parseFloat("{{$design->column_w}}"),
                            "tie_beam_h": parseFloat("{{$design->top_plate_h}}"),
                        },
                    }),
                    success: function (data, textStatus, jQxhr) {
                        const response = JSON.parse(jQxhr.responseText);

                        $('#joint1_dtl_clm').val(response.dtl_clm.value).change()
                        $('#joint1_dtj_clm').val(response.dtj_clm.value).change()
                        $('#joint1_btl_clm').val(response.btl_clm.value).change()
                        $('#joint1_ttl_clm').val(response.ttl_clm.value).change()
                        $('#joint1_dtt_clm').val(response.dtt_clm.value).change()
                        $('#joint1_b_clm').val(response.b_clm.value).change()

                        $('#joint2_jc1').val(response.jc1.value).change()
                        $('#joint2_jc2').val(response.jc2.value).change()
                        $('#joint2_jc3').val(response.jc3.value).change()
                        $('#joint2_jc4').val(response.jc4.value).change()
                        $('#joint2_jc5').val(response.jc5.value).change()
                        $('#joint2_jc6').val(response.jc6.value).change()
                        $('#joint2_jc7').val(response.jc7.value).change()

                        $('#joint4_d').val(response.D.value).change()
                        $('#joint4_btucl').val(response.btu_clm.value).change()
                        $('#joint4_lsu_s_b').val(response.lsu_s_b.value).change()
                        $('#joint4_l_scr').val(response.l_scr.value).change()
                        $('#joint4_ttu_clm').val(response.ttu_clm.value).change()
                        $('#joint4_esb').val(response.e_sb.value).change()
                        $('#joint4_leu_sb').val(response.leu_s_b.value).change()
                        $('#joint4_glsb').val(response.gl_s_b.value).change()
                        $('#joint4_tb').val(response.t_b.value).change()
                        $('#joint4_wb').val(response.w_b.value).change()
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        const response = JSON.parse(jqXhr.responseText);
                        alert(response)
                    },
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            })

            $('#joint_3').on('click', function () {
                const url = "{!! env('FLASK_URL') !!}" + '/joint3';

                $.ajax({
                    url: url,
                    type: 'POST',
                    async: true,
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "material": {
                            "dtl_e": parseFloat("{{$wood_model->dtl_e}}"),
                            "dtl_g": parseFloat("{{$wood_model->dtl_g}}"),
                            "dtl_s": parseFloat("{{$wood_model->dtl_s}}"),
                            "dtl_v": parseFloat("{{$wood_model->dtl_v}}")
                        },
                        "cross_section": {
                            "column_h": parseFloat("{{$design->column_h}}"),
                            "column_w": parseFloat("{{$design->column_w}}"),
                            "tie_beam_h": parseFloat("{{$design->top_plate_h}}"),
                        }
                    }),
                    success: function (data, textStatus, jQxhr) {
                        const response = JSON.parse(jQxhr.responseText);

                        $('#joint3_lim_e').val(response.lim_e.value).change()
                        $('#joint3_lim_s').val(response.lim_s.value).change()
                        $('#joint3_lim_v').val(response.lim_v.value).change()
                        $('#joint3_lim_g').val(response.lim_g.value).change()
                        $('#joint3_d').val(response.d.value).change()
                        $('#joint3_capacity_kN').text("capacity : " + response.capacity_kN.print_value).change()
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        const response = JSON.parse(jqXhr.responseText);
                        alert(response)
                    },
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            })
        })
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">

                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div
                            class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                            style="width: 100%"> 100%
                        </div>
                    </div>

                    <form method="post" action="{{ route('design.store.step5') }}" class="mt-6 space-y-6"
                          enctype="multipart/form-data">
                        @csrf

                        <div>
                            Enter joints details or use
                            <x-secondary-button id="calculator">{{__('Calculator')}}</x-secondary-button>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <div>
                                    <x-input-label for="joint_1" :value="__('Joint 1')"/>
                                    <x-text-input id="joint1" name="joint1" type="text" class="mt-1 block w-full"
                                                  :value="JointTypeEnum::tenon_joint->value" required autofocus
                                                  autocomplete="joint1" readonly/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint1_dtl_clm" :value="__('dtl_clm (mm)')"/>
                                    <x-text-input id="joint1_dtl_clm" name="joint1_dtl_clm" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint1_dtl_clm" required
                                                  autofocus autocomplete="joint1_dtl_clm"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1_dtl_clm')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint1_dtj_clm" :value="__('dtj_clm (mm)')"/>
                                    <x-text-input id="joint1_dtj_clm" name="joint1_dtj_clm" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint1_dtj_clm" required
                                                  autofocus autocomplete="joint1_dtj_clm"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1_dtj_clm')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint1_btl_clm" :value="__('btl_clm (mm)')"/>
                                    <x-text-input id="joint1_btl_clm" name="joint1_btl_clm" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint1_btl_clm" required
                                                  autofocus autocomplete="joint1_btl_clm"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1_btl_clm')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint1_ttl_clm" :value="__('ttl_clm (mm)')"/>
                                    <x-text-input id="joint1_ttl_clm" name="joint1_ttl_clm" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint1_ttl_clm" required
                                                  autofocus autocomplete="joint1_ttl_clm"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1_ttl_clm')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint1_b_clm" :value="__('b_clm (mm)')"/>
                                    <x-text-input id="joint1_b_clm" name="joint1_b_clm" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint1_b_clm" required
                                                  autofocus autocomplete="joint1_b_clm"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1_b_clm')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint1_dtt_clm" :value="__('dtt_clm (mm)')"/>
                                    <x-text-input id="joint1_dtt_clm" name="joint1_dtt_clm" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint1_dtt_clm" required
                                                  autofocus autocomplete="joint1_dtt_clm"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1_dtt_clm')"/>
                                </div>


                            </div>

                            <div class="basis-1/2 ml-2 content-center justify-center">
                                <img style="max-height: 500px;" class="p-8" src="{{asset('/images/Joint_1.jpg')}}"
                                     alt="Helper">
                            </div>
                        </div>

                        <hr>

                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <div>
                                    <x-input-label for="joint_2" :value="__('Joint 2')"/>
                                    <x-text-input id="joint2" name="joint2" type="text" class="mt-1 block w-full"
                                                  :value="JointTypeEnum::gooseneck_joint->value" required autofocus
                                                  autocomplete="joint2" readonly/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc1" :value="__('jc1 (mm)')"/>
                                    <x-text-input id="joint2_jc1" name="joint2_jc1" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint2_jc1" required
                                                  autofocus autocomplete="joint2_jc1"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc1')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc2" :value="__('jc2 (mm)')"/>
                                    <x-text-input id="joint2_jc2" name="joint2_jc2" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint2_jc2" required
                                                  autofocus autocomplete="joint2_jc2"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc2')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc3" :value="__('jc3 (mm)')"/>
                                    <x-text-input id="joint2_jc3" name="joint2_jc3" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint2_jc3" required
                                                  autofocus autocomplete="joint2_jc3"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc3')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc4" :value="__('jc4 (mm)')"/>
                                    <x-text-input id="joint2_jc4" name="joint2_jc4" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint2_jc4" required
                                                  autofocus autocomplete="joint2_jc4"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc4')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc5" :value="__('jc5 (mm)')"/>
                                    <x-text-input id="joint2_jc5" name="joint2_jc5" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint2_jc5" required
                                                  autofocus autocomplete="joint2_jc5"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc5')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc6" :value="__('jc6 (mm)')"/>
                                    <x-text-input id="joint2_jc6" name="joint2_jc6" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint2_jc6" required
                                                  autofocus autocomplete="joint2_jc6"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc6')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc7" :value="__('jc7 (mm)')"/>
                                    <x-text-input id="joint2_jc7" name="joint2_jc7" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint2_jc7" required
                                                  autofocus autocomplete="joint2_jc7"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc7')"/>
                                </div>
                            </div>

                            <div class="basis-1/2 ml-2 content-center justify-center">
                                <img style="max-height: 500px;" class="p-8" src="{{asset('/images/Joint_2.jpg')}}"
                                     alt="Helper">
                            </div>
                        </div>

                        <hr>

                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <div>
                                    <x-input-label for="joint_3" :value="__('Joint 3')"/>
                                    <x-select id="joint_3" name="joint3" class="mt-1 block w-full" required autofocus
                                              autocomplete="joint3">
                                        <option value={{JointTypeEnum::pegged_mortise_and_tenon->value}}
                                                    @if($design->joint3 == JointTypeEnum::pegged_mortise_and_tenon->value) selected @endif>{{JointTypeEnum::pegged_mortise_and_tenon->value}}</option>

                                        <option value={{JointTypeEnum::pegged_mortise_and_tenon->value . "_" . $wood_model->name}}
                                                @if($design->joint3 == JointTypeEnum::pegged_mortise_and_tenon->value . "_" . $wood_model->name) selected @endif>
                                            {{JointTypeEnum::pegged_mortise_and_tenon->value . "_" . $wood_model->name}}
                                        </option>
                                    </x-select>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint3_lim_e" :value="__('lim_e (mm)')"/>
                                    <x-text-input id="joint3_lim_e" name="joint3_lim_e" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint3_lim_e" required
                                                  autofocus autocomplete="joint3_lim_e"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_lim_e')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint3_lim_s" :value="__('lim_s (mm)')"/>
                                    <x-text-input id="joint3_lim_s" name="joint3_lim_s" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint3_lim_s" required
                                                  autofocus autocomplete="joint3_lim_s"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_lim_s')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint3_lim_v" :value="__('lim_v (mm)')"/>
                                    <x-text-input id="joint3_lim_v" name="joint3_lim_v" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint3_lim_v" required
                                                  autofocus autocomplete="joint3_lim_v"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_lim_v')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint3_lim_g" :value="__('lim_g (mm)')"/>
                                    <x-text-input id="joint3_lim_g" name="joint3_lim_g" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint3_lim_g" required
                                                  autofocus autocomplete="joint3_lim_g"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_lim_g')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint3_d" :value="__('d (mm)')"/>
                                    <x-text-input id="joint3_d" name="joint3_d" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint3_d" required
                                                  autofocus autocomplete="joint3_d"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_d')"/>
                                </div>

                                <div id="joint3_capacity_kN"></div>
                            </div>

                            <div class="basis-1/2 ml-2 content-center justify-center">
                                <img style="max-height: 500px;" class="p-8" src="{{asset('/images/Joint_3.jpg')}}"
                                     alt="Helper">
                            </div>
                        </div>

                        <hr>

                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <div>
                                    <x-input-label for="joint_4" :value="__('Joint 4')"/>
                                    <x-text-input id="joint4" name="joint4" type="text" class="mt-1 block w-full"
                                                  :value="JointTypeEnum::scarf_joint->value" required autofocus
                                                  autocomplete="joint4" readonly/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint4_d" :value="__('D (mm)')"/>
                                    <x-text-input id="joint4_d" name="joint4_d" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint4_d" required
                                                  autofocus autocomplete="joint4_d"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_d')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint4_btucl" :value="__('btucl (mm)')"/>
                                    <x-text-input id="joint4_btucl" name="joint4_btucl" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint4_btucl" required
                                                  autofocus autocomplete="joint4_btucl"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_btucl')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint4_ttu_clm" :value="__('ttu_clm (mm)')"/>
                                    <x-text-input id="joint4_ttu_clm" name="joint4_ttu_clm" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint4_ttu_clm" required
                                                  autofocus autocomplete="joint4_ttu_clm"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_ttu_clm')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint4_l_scr" :value="__('l_scr (mm)')"/>
                                    <x-text-input id="joint4_l_scr" name="joint4_l_scr" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint4_l_scr" required
                                                  autofocus autocomplete="joint4_l_scr"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_l_scr')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint4_esb" :value="__('esb (mm)')"/>
                                    <x-text-input id="joint4_esb" name="joint4_esb" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint4_esb" required
                                                  autofocus autocomplete="joint4_esb"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_esb')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint4_leu_sb" :value="__('leu_sb (mm)')"/>
                                    <x-text-input id="joint4_leu_sb" name="joint4_leu_sb" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint4_leu_sb" required
                                                  autofocus autocomplete="joint4_leu_sb"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_leu_sb')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint4_lsu_s_b" :value="__('lsu_s_b (mm)')"/>
                                    <x-text-input id="joint4_lsu_s_b" name="joint4_lsu_s_b" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint4_lsu_s_b" required
                                                  autofocus autocomplete="joint4_lsu_s_b"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_lsu_s_b')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint4_glsb" :value="__('glsb (mm)')"/>
                                    <x-text-input id="joint4_glsb" name="joint4_glsb" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint4_glsb" required
                                                  autofocus autocomplete="joint4_glsb"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_glsb')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint4_tb" :value="__('tb (mm)')"/>
                                    <x-text-input id="joint4_tb" name="joint4_tb" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint4_tb" required
                                                  autofocus autocomplete="joint4_tb"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_tb')"/>
                                </div>

                                <div>
                                    <x-input-label for="joint4_wb" :value="__('wb (mm)')"/>
                                    <x-text-input id="joint4_wb" name="joint4_wb" type="number" step="0.01"
                                                  class="mt-1 block w-full" :value="$design->joint4_wb" required
                                                  autofocus autocomplete="joint4_wb"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_wb')"/>
                                </div>
                            </div>

                            <div class="basis-1/2 ml-2 content-center justify-center">
                                <img style="max-height: 500px;" class="p-8" src="{{asset('/images/Joint_4.jpg')}}"
                                     alt="Helper">
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{route('design.create.step4')}}">
                                <x-secondary-button>{{__('Previous')}}</x-secondary-button>
                            </a>

                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
