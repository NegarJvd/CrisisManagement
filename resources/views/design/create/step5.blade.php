<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Design') }}
        </h2>
    </x-slot>

    <script type="module">
        $(document).ready(function() {
            $('#joint_detail_select').on('click', function (){
                $('#optimizer_result').removeClass('hidden')

                $('#joint_d').val(24.416);
                $('#joint_lim_e').val(56.85);
                $('#joint_lim_g').val(42.64);
                $('#joint_lim_s').val(71.07);
                $('#joint_lim_v').val(42.64)

            })
        })
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">

                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 100%"> 100%</div>
                    </div>

                    <form method="post" action="{{ route('design.store.step5') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <h2>
                            Enter joints type:
                        </h2>

                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <div>
                                    <x-input-label for="joint_1" :value="__('Joint 1')" />
                                    <x-select id="joint_1" name="joint1" class="mt-1 block w-full" required autofocus autocomplete="joint1">
                                        @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                            <option value="{{$joint_type}}" @if($design->joint1 == $joint_type) selected @endif>{{$joint_type}}</option>
                                        @endforeach
                                    </x-select>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1')" />
                                </div>

                                <div>
                                    <x-input-label for="joint1_dtl_clm" :value="__('dtl_clm (mm)')" />
                                    <x-text-input id="joint1_dtl_clm" name="joint1_dtl_clm" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint1_dtl_clm" required autofocus autocomplete="joint1_dtl_clm" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1_dtl_clm')" />
                                </div>

                                <div>
                                    <x-input-label for="joint1_dtj_clm" :value="__('dtj_clm (mm)')" />
                                    <x-text-input id="joint1_dtj_clm" name="joint1_dtj_clm" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint1_dtj_clm" required autofocus autocomplete="joint1_dtj_clm" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1_dtj_clm')" />
                                </div>

                                <div>
                                    <x-input-label for="joint1_btl_clm" :value="__('btl_clm (mm)')" />
                                    <x-text-input id="joint1_btl_clm" name="joint1_btl_clm" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint1_btl_clm" required autofocus autocomplete="joint1_btl_clm" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1_btl_clm')" />
                                </div>

                                <div>
                                    <x-input-label for="joint1_ttl_clm" :value="__('ttl_clm (mm)')" />
                                    <x-text-input id="joint1_ttl_clm" name="joint1_ttl_clm" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint1_ttl_clm" required autofocus autocomplete="joint1_ttl_clm" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1_ttl_clm')" />
                                </div>

                                <div>
                                    <x-input-label for="joint1_b_clm" :value="__('b_clm (mm)')" />
                                    <x-text-input id="joint1_b_clm" name="joint1_b_clm" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint1_b_clm" required autofocus autocomplete="joint1_b_clm" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint1_b_clm')" />
                                </div>
                            </div>

                            <div class="basis-1/2 ml-2 content-center">
                                <img style="max-height: 500px;" class="p-8" src="{{asset('/images/Joint_1.jpg')}}" alt="Helper">
                            </div>
                        </div>

                        <hr>

                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <div>
                                    <x-input-label for="joint_2" :value="__('Joint 2')" />
                                    <x-select id="joint_2" name="joint2" class="mt-1 block w-full" required autofocus autocomplete="joint2">
                                        @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                            <option value="{{$joint_type}}" @if($design->joint2 == $joint_type) selected @endif>{{$joint_type}}</option>
                                        @endforeach
                                    </x-select>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2')" />
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc1" :value="__('jc1 (mm)')" />
                                    <x-text-input id="joint2_jc1" name="joint2_jc1" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint2_jc1" required autofocus autocomplete="joint2_jc1" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc1')" />
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc2" :value="__('jc2 (mm)')" />
                                    <x-text-input id="joint2_jc2" name="joint2_jc2" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint2_jc2" required autofocus autocomplete="joint2_jc2" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc2')" />
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc3" :value="__('jc3 (mm)')" />
                                    <x-text-input id="joint2_jc3" name="joint2_jc3" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint2_jc3" required autofocus autocomplete="joint2_jc3" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc3')" />
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc4" :value="__('jc4 (mm)')" />
                                    <x-text-input id="joint2_jc4" name="joint2_jc4" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint2_jc4" required autofocus autocomplete="joint2_jc4" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc4')" />
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc5" :value="__('jc5 (mm)')" />
                                    <x-text-input id="joint2_jc5" name="joint2_jc5" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint2_jc5" required autofocus autocomplete="joint2_jc5" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc5')" />
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc6" :value="__('jc6 (mm)')" />
                                    <x-text-input id="joint2_jc6" name="joint2_jc6" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint2_jc6" required autofocus autocomplete="joint2_jc6" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc6')" />
                                </div>

                                <div>
                                    <x-input-label for="joint2_jc7" :value="__('jc7 (mm)')" />
                                    <x-text-input id="joint2_jc7" name="joint2_jc7" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint2_jc7" required autofocus autocomplete="joint2_jc7" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint2_jc7')" />
                                </div>
                            </div>

                            <div class="basis-1/2 ml-2 content-center">
                                <img style="max-height: 500px;" class="p-8" src="{{asset('/images/Joint_2.jpg')}}" alt="Helper">
                            </div>
                        </div>

                        <hr>

                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <div>
                                    <x-input-label for="joint_3" :value="__('Joint 3')" />
                                    <x-select id="joint_3" name="joint3" class="mt-1 block w-full" required autofocus autocomplete="joint3">
                                        @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                            <option value="{{$joint_type}}" @if($design->joint3 == $joint_type) selected @endif>{{$joint_type}}</option>
                                        @endforeach
                                    </x-select>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3')" />
                                </div>

                                <div>
                                    <x-input-label for="joint3_lim_e" :value="__('lim_e (mm)')" />
                                    <x-text-input id="joint3_lim_e" name="joint3_lim_e" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint3_lim_e" required autofocus autocomplete="joint3_lim_e" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_lim_e')" />
                                </div>

                                <div>
                                    <x-input-label for="joint3_lim_s" :value="__('lim_s (mm)')" />
                                    <x-text-input id="joint3_lim_s" name="joint3_lim_s" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint3_lim_s" required autofocus autocomplete="joint3_lim_s" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_lim_s')" />
                                </div>

                                <div>
                                    <x-input-label for="joint3_lim_v" :value="__('lim_v (mm)')" />
                                    <x-text-input id="joint3_lim_v" name="joint3_lim_v" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint3_lim_v" required autofocus autocomplete="joint3_lim_v" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_lim_v')" />
                                </div>

                                <div>
                                    <x-input-label for="joint3_lim_g" :value="__('lim_g (mm)')" />
                                    <x-text-input id="joint3_lim_g" name="joint3_lim_g" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint3_lim_g" required autofocus autocomplete="joint3_lim_g" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_lim_g')" />
                                </div>

                                <div>
                                    <x-input-label for="joint3_lim_t" :value="__('lim_t (mm)')" />
                                    <x-text-input id="joint3_lim_t" name="joint3_lim_t" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint3_lim_t" required autofocus autocomplete="joint3_lim_t" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_lim_t')" />
                                </div>

                                <div>
                                    <x-input-label for="joint3_wtb" :value="__('wtb (mm)')" />
                                    <x-text-input id="joint3_wtb" name="joint3_wtb" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint3_wtb" required autofocus autocomplete="joint3_wtb" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_wtb')" />
                                </div>

                                <div>
                                    <x-input-label for="joint3_wt" :value="__('wt (mm)')" />
                                    <x-text-input id="joint3_wt" name="joint3_wt" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint3_wt" required autofocus autocomplete="joint3_wt" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_wt')" />
                                </div>

                                <div>
                                    <x-input-label for="joint3_tt" :value="__('tt (mm)')" />
                                    <x-text-input id="joint3_tt" name="joint3_tt" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint3_tt" required autofocus autocomplete="joint3_tt" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_tt')" />
                                </div>

                                <div>
                                    <x-input-label for="joint3_s2_clm" :value="__('s2_clm (mm)')" />
                                    <x-text-input id="joint3_s2_clm" name="joint3_s2_clm" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint3_s2_clm" required autofocus autocomplete="joint3_s2_clm" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint3_s2_clm')" />
                                </div>
                            </div>

                            <div class="basis-1/2 ml-2 content-center">
                                <img style="max-height: 500px;" class="p-8" src="{{asset('/images/Joint_3.jpg')}}" alt="Helper">
                            </div>
                        </div>

                        <hr>

                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <div>
                                    <x-input-label for="joint_4" :value="__('Joint 4')" />
                                    <x-select id="joint_4" name="joint4" class="mt-1 block w-full" required autofocus autocomplete="joint4">
                                        @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                            <option value="{{$joint_type}}" @if($design->joint4 == $joint_type) selected @endif>{{$joint_type}}</option>
                                        @endforeach
                                    </x-select>
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4')" />
                                </div>

                                <div>
                                    <x-input-label for="joint4_btucl" :value="__('btucl (mm)')" />
                                    <x-text-input id="joint4_btucl" name="joint4_btucl" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint4_btucl" required autofocus autocomplete="joint4_btucl" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_btucl')" />
                                </div>

                                <div>
                                    <x-input-label for="joint4_ttu_clm" :value="__('ttu_clm (mm)')" />
                                    <x-text-input id="joint4_ttu_clm" name="joint4_ttu_clm" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint4_ttu_clm" required autofocus autocomplete="joint4_ttu_clm" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_ttu_clm')" />
                                </div>

                                <div>
                                    <x-input-label for="joint4_gu_sb" :value="__('gu_sb (mm)')" />
                                    <x-text-input id="joint4_gu_sb" name="joint4_gu_sb" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint4_gu_sb" required autofocus autocomplete="joint4_gu_sb" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_gu_sb')" />
                                </div>

                                <div>
                                    <x-input-label for="joint4_esb" :value="__('esb (mm)')" />
                                    <x-text-input id="joint4_esb" name="joint4_esb" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint4_esb" required autofocus autocomplete="joint4_esb" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_esb')" />
                                </div>

                                <div>
                                    <x-input-label for="joint4_leu_sb" :value="__('leu_sb (mm)')" />
                                    <x-text-input id="joint4_leu_sb" name="joint4_leu_sb" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint4_leu_sb" required autofocus autocomplete="joint4_leu_sb" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_leu_sb')" />
                                </div>

                                <div>
                                    <x-input-label for="joint4_lsus" :value="__('lsus (mm)')" />
                                    <x-text-input id="joint4_lsus" name="joint4_lsus" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint4_lsus" required autofocus autocomplete="joint4_lsus" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_lsus')" />
                                </div>

                                <div>
                                    <x-input-label for="joint4_glsb" :value="__('glsb (mm)')" />
                                    <x-text-input id="joint4_glsb" name="joint4_glsb" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint4_glsb" required autofocus autocomplete="joint4_glsb" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_glsb')" />
                                </div>

                                <div>
                                    <x-input-label for="joint4_lsb" :value="__('lsb (mm)')" />
                                    <x-text-input id="joint4_lsb" name="joint4_lsb" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint4_lsb" required autofocus autocomplete="joint4_lsb" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_lsb')" />
                                </div>

                                <div>
                                    <x-input-label for="joint4_tb" :value="__('tb (mm)')" />
                                    <x-text-input id="joint4_tb" name="joint4_tb" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint4_tb" required autofocus autocomplete="joint4_tb" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_tb')" />
                                </div>

                                <div>
                                    <x-input-label for="joint4_wb" :value="__('wb (mm)')" />
                                    <x-text-input id="joint4_wb" name="joint4_wb" type="number" step="0.1" class="mt-1 block w-full" :value="$design->joint4_wb" required autofocus autocomplete="joint4_wb" />
                                    <x-input-error class="mt-2" :messages="$errors->get('joint4_wb')" />
                                </div>
                            </div>

                            <div class="basis-1/2 ml-2 content-center">
                                <img style="max-height: 500px;" class="p-8" src="{{asset('/images/Joint_4.jpg')}}" alt="Helper">
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{route('design.create.step4')}}">
                                <x-secondary-button>{{__('Previous')}}</x-secondary-button>
                            </a>

                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                            <x-select id="joint_detail_select" class="mt-1 block" required autofocus autocomplete="joint_detail_select">
                                <option>optimize method 1</option>
                                <option>optimize method 2</option>
                                <option>optimize method 3</option>
                            </x-select>
                        </div>
                    </form>

                    <div id="optimizer_result" class="hidden mt-4">
                        joints details:
                        D (mm): 26.416, lim_e (mm): 56.85, lim_s (mm): 71.07, lim_v (mm): 42.64, lim_g (mm): 42.64, Capacity (kN): 11.47, Status: Acceptable
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
