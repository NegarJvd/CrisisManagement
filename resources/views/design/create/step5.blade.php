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
                            Enter joint type:
                        </h2>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="joint_1" :value="__('Joint 1')" />
                                <x-select id="joint_1" name="joint1" class="mt-1 block w-full" required autofocus autocomplete="joint1">
                                    @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                        <option value="{{$joint_type}}" @if($design->joint1 == $joint_type) selected @endif>{{$joint_type}}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('joint1')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="joint_2" :value="__('Joint 2')" />
                                <x-select id="joint_2" name="joint2" class="mt-1 block w-full" required autofocus autocomplete="joint2">
                                    @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                        <option value="{{$joint_type}}" @if($design->joint2 == $joint_type) selected @endif>{{$joint_type}}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('joint2')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="joint_3" :value="__('Joint 3')" />
                                <x-select id="joint_3" name="joint3" class="mt-1 block w-full" required autofocus autocomplete="joint3">
                                    @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                        <option value="{{$joint_type}}" @if($design->joint3 == $joint_type) selected @endif>{{$joint_type}}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('joint3')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="joint_4" :value="__('Joint 4')" />
                                <x-select id="joint_4" name="joint4" class="mt-1 block w-full" required autofocus autocomplete="joint4">
                                    @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                        <option value="{{$joint_type}}" @if($design->joint4 == $joint_type) selected @endif>{{$joint_type}}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('joint4')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="joint_d" :value="__('D (mm)')" />
                                <x-text-input id="joint_d" name="joint_d" type="text" class="mt-1 block w-full" :value="$design->joint_d" required autofocus autocomplete="joint_d" />
                                <x-input-error class="mt-2" :messages="$errors->get('joint_d')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="joint_lim_e" :value="__('lim_e (mm)')" />
                                <x-text-input id="joint_lim_e" name="joint_lim_e" type="text" class="mt-1 block w-full" :value="$design->joint_lim_e" required autofocus autocomplete="joint_lim_e" />
                                <x-input-error class="mt-2" :messages="$errors->get('joint_lim_e')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="joint_lim_s" :value="__('lim_s (mm)')" />
                                <x-text-input id="joint_lim_s" name="joint_lim_s" type="text" class="mt-1 block w-full" :value="$design->joint_lim_s" required autofocus autocomplete="joint_lim_s" />
                                <x-input-error class="mt-2" :messages="$errors->get('joint_lim_s')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="joint_lim_v" :value="__('lim_v (mm)')" />
                                <x-text-input id="joint_lim_v" name="joint_lim_v" type="text" class="mt-1 block w-full" :value="$design->joint_lim_v" required autofocus autocomplete="joint_lim_v" />
                                <x-input-error class="mt-2" :messages="$errors->get('joint_lim_v')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="joint_lim_g" :value="__('lim_g (mm)')" />
                                <x-text-input id="joint_lim_g" name="joint_lim_g" type="text" class="mt-1 block w-full" :value="$design->joint_lim_g" required autofocus autocomplete="joint_lim_g" />
                                <x-input-error class="mt-2" :messages="$errors->get('joint_lim_g')" />
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
