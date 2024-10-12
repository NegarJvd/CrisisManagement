<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Design') }}
        </h2>
    </x-slot>

    <script type="module">
        $(document).ready(function() {
            $('#optimizer').on('click', function (){
                //calculate data for send to api
                const length = "{{$design->length}}";
                const column_number = "{{$design->column_number}}";
                const l = length / ((column_number / 2) - 1)

                $('#optimizer_result').removeClass('hidden')

                // calculating from api results
                // const beam_w = weight.value
                // const beam_h = thickness.value
                //
                // const column_w = weight.value
                // const column_h = thickness.value
                //
                // const top_plate_w = weight.value
                // const top_plate_h = (3/2) * thickness.value
                //
                // const long_sill_h = weight.value
                // const long_sill_w = (5/4) * thickness.value


                $('#beam_w').val(85);
                $('#column_w').val(85);
                $('#top_plate_w').val(85);
                $('#long_sill_w').val(85);

                $('#beam_h').val(127);
                $('#column_h').val(127);
                $('#top_plate_h').val(127);
                $('#long_sill_h').val(127);

            })
        })
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">

                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 80%"> 80%</div>
                    </div>

                    <form method="post" action="{{ route('design.store.step4') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div class="flex flex-row">
                            <div class="w-full m-4 p-4">
                                <img src="{{asset('/images/cross_section.jpg')}}" alt="Helper">
                            </div>
                        </div>

                        <h2>
                            Enter cross section details:
                        </h2>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="beam_w" :value="__('Beam width')" />
                                <x-text-input id="beam_w" name="beam_w" type="number" step="0.1" class="mt-1 block w-full" :value="$design->beam_w" required autofocus autocomplete="beam_w" />
                                <x-input-error class="mt-2" :messages="$errors->get('beam_w')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="column_w" :value="__('Column width')" />
                                <x-text-input id="column_w" name="column_w" type="number" step="0.1" class="mt-1 block w-full" :value="$design->column_w" required autofocus autocomplete="column_w" />
                                <x-input-error class="mt-2" :messages="$errors->get('column_w')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="top_plate_w" :value="__('Tie beam width')" />
                                <x-text-input id="top_plate_w" name="top_plate_w" type="number" step="0.1" class="mt-1 block w-full" :value="$design->top_plate_w" required autofocus autocomplete="top_plate_w" />
                                <x-input-error class="mt-2" :messages="$errors->get('top_plate_w')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="long_sill_w" :value="__('Bottom sill width')" />
                                <x-text-input id="long_sill_w" name="long_sill_w" type="number" step="0.1" class="mt-1 block w-full" :value="$design->long_sill_w" required autofocus autocomplete="long_sill_w" />
                                <x-input-error class="mt-2" :messages="$errors->get('long_sill_w')" />
                            </div>
                        </div>


                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="beam_h" :value="__('Beam height')" />
                                <x-text-input id="beam_h" name="beam_h" type="number" step="0.1" class="mt-1 block w-full" :value="$design->beam_h" required autofocus autocomplete="beam_h" />
                                <x-input-error class="mt-2" :messages="$errors->get('beam_h')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="column_h" :value="__('Column height')" />
                                <x-text-input id="column_h" name="column_h" type="number" step="0.1" class="mt-1 block w-full" :value="$design->column_h" required autofocus autocomplete="column_h" />
                                <x-input-error class="mt-2" :messages="$errors->get('column_h')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="top_plate_h" :value="__('Tie beam height')" />
                                <x-text-input id="top_plate_h" name="top_plate_h" type="number" step="0.1" class="mt-1 block w-full" :value="$design->top_plate_h" required autofocus autocomplete="top_plate_h" />
                                <x-input-error class="mt-2" :messages="$errors->get('top_plate_h')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="long_sill_h" :value="__('Bottom sill height')" />
                                <x-text-input id="long_sill_h" name="long_sill_h" type="number" step="0.1" class="mt-1 block w-full" :value="$design->long_sill_h" required autofocus autocomplete="long_sill_h" />
                                <x-input-error class="mt-2" :messages="$errors->get('long_sill_h')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{route('design.create.step3')}}">
                                <x-secondary-button>{{__('Previous')}}</x-secondary-button>
                            </a>

                            <x-primary-button>{{ __('Save and next') }}</x-primary-button>

                            <x-select id="optimizer" class="mt-1 block" required autofocus autocomplete="optimizer">
                                <option>optimize method 1</option>
                                <option>optimize method 2</option>
                                <option>optimize method 3</option>
                            </x-select>
                        </div>
                    </form>

                    <div id="optimizer_result" class="hidden mt-4">
                        Weight: 13.17 kg, width: 85 mm, height: 127 mm, Beam Length: 2.00 m, Bending Utilisation(beam): 35.78%, Bending Status (beam): Acceptable, Shear Utilisation(beam) : 22.97%, Shear Status (beam): Acceptable, SLS Utilisation(beam): 99.61%, SLS Status(beam): Acceptable, b.clm: 85 mm, w.clm: 127.00 mm, w.tb: 127 mm, t.t: 190.50 mm, Compression Utilisation(column): 3.79%, Compression status(column): Acceptable, Buckling Utilisation in plane(column): 2.48%, Buckling status in plane(column): Acceptable,Buckling Utilisation out of plane (column): 4.72%, Buckling status out of plane(column): Acceptable, Final Utilisation: 99.61%, Final utilisation status: Acceptable
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
