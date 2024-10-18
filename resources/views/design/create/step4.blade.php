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

                let load_calculator_values_as_object = "{{$load_calculator_values_as_object}}"
                load_calculator_values_as_object = load_calculator_values_as_object.replace(/&quot;/g, '"');
                const load_data = JSON.parse(load_calculator_values_as_object)

                const url = "{!! env('FLASK_URL') !!}" + '/cross_section';

                $.ajax({
                    url: url,
                    type: 'POST',
                    async: true,
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "footprint": {
                            "height": parseFloat("{{$design->height}}"),
                            "beam_length": parseFloat(l)
                        },
                        "load": load_data,
                        "material": {
                            "bending_strength": parseFloat("{{$wood_model->bending_strength}}"),
                            "compression_parallel": parseFloat("{{$wood_model->compression_parallel}}"),
                            "creep_factor": parseFloat("{{$wood_model->creep_factor}}"),
                            "creep_factor_solid_timber": parseFloat("{{$wood_model->creep_factor_solid_timber}}"),
                            "density": parseFloat("{{$wood_model->density}}"),
                            "e_modulus": parseFloat("{{$wood_model->e_modulus}}"),
                            "e_modulus_5": parseFloat("{{$wood_model->e_modulus_5}}"),
                            "modification_factor_instantaneous_term": parseFloat("{{$wood_model->modification_factor_instantaneous_term}}"),
                            "modification_factor_medium_term": parseFloat("{{$wood_model->modification_factor_medium_term}}"),
                            "modification_factor_permanent_term": parseFloat("{{$wood_model->modification_factor_permanent_term}}"),
                            "partial_factor": parseFloat("{{$wood_model->partial_factor}}"),
                            "shear_strength": parseFloat("{{$wood_model->shear_strength}}")
                        }
                    }),
                    success: function (data, textStatus, jQxhr) {
                        const response = JSON.parse(jQxhr.responseText);
                        // console.log(response)
                        const optimizer_result = document.getElementById('optimizer_result')
                        optimizer_result.innerHTML = ""

                        for (let i = 0; i < response.length; i++){
                            const div = document.createElement('div');
                            div.classList.add('border', 'border-gray-300', 'rounded-lg', 'p-4', 'mt-2');
                            const cross_section_option = response[i]
                            let div_text = "";

                            const print_value = document.createElement('p')
                            let weight_input
                            let thickness_input
                            let final_utilisation_status

                            // Iterate over all the keys in the object
                            for (let key in cross_section_option) {
                                if (typeof cross_section_option[key] === 'object' && cross_section_option[key].print_value) {
                                    div_text += key + " : " + cross_section_option[key].print_value + ", "

                                    if (key === "final_utilisation_status") {
                                        final_utilisation_status = cross_section_option[key].value
                                    }

                                    if (key === "weight"){
                                        weight_input = document.createElement('input')
                                        weight_input.type = 'number'
                                        weight_input.value = cross_section_option[key].value
                                        weight_input.classList.add('cross_section_optimization_weight', 'hidden')
                                    }

                                    if (key === "thickness"){
                                        thickness_input = document.createElement('input')
                                        thickness_input.type = 'number'
                                        thickness_input.value = cross_section_option[key].value
                                        thickness_input.classList.add('cross_section_optimization_thickness', 'hidden')
                                    }
                                }
                            }
                            print_value.textContent = div_text
                            div.appendChild(print_value)
                            div.appendChild(weight_input)
                            div.appendChild(thickness_input)

                            if (final_utilisation_status){
                                div.classList.add('fill_the_cross_section', 'cursor-pointer', 'hover:bg-gray-100')
                            }else{
                                div.classList.add('cursor-not-allowed')
                            }

                            optimizer_result.appendChild(div)
                        }

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

        $(document).on('click', '.fill_the_cross_section', function (){
            $('.fill_the_cross_section').removeClass('bg-gray-300')
            $(this).addClass('bg-gray-300')

            // calculating from api results
            const weight = $(this).find('.cross_section_optimization_weight').val()
            const thickness = $(this).find('.cross_section_optimization_thickness').val()

            const beam_w = weight
            const beam_h = thickness

            const column_w = weight
            const column_h = thickness

            const top_plate_w = weight
            const top_plate_h = (3/2) * thickness

            const long_sill_h = weight
            const long_sill_w = (5/4) * thickness

            $('#beam_w').val(beam_w).change();
            $('#column_w').val(column_w).change();
            $('#top_plate_w').val(top_plate_w).change();
            $('#long_sill_w').val(long_sill_w).change();

            $('#beam_h').val(beam_h).change();
            $('#column_h').val(column_h).change();
            $('#top_plate_h').val(top_plate_h).change();
            $('#long_sill_h').val(long_sill_h).change();
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
                                <x-text-input id="beam_w" name="beam_w" type="number" step="0.01" class="mt-1 block w-full" :value="$design->beam_w" required autofocus autocomplete="beam_w" />
                                <x-input-error class="mt-2" :messages="$errors->get('beam_w')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="column_w" :value="__('Column width')" />
                                <x-text-input id="column_w" name="column_w" type="number" step="0.01" class="mt-1 block w-full" :value="$design->column_w" required autofocus autocomplete="column_w" />
                                <x-input-error class="mt-2" :messages="$errors->get('column_w')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="top_plate_w" :value="__('Tie beam width')" />
                                <x-text-input id="top_plate_w" name="top_plate_w" type="number" step="0.01" class="mt-1 block w-full" :value="$design->top_plate_w" required autofocus autocomplete="top_plate_w" />
                                <x-input-error class="mt-2" :messages="$errors->get('top_plate_w')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="long_sill_w" :value="__('Bottom sill width')" />
                                <x-text-input id="long_sill_w" name="long_sill_w" type="number" step="0.01" class="mt-1 block w-full" :value="$design->long_sill_w" required autofocus autocomplete="long_sill_w" />
                                <x-input-error class="mt-2" :messages="$errors->get('long_sill_w')" />
                            </div>
                        </div>


                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="beam_h" :value="__('Beam height')" />
                                <x-text-input id="beam_h" name="beam_h" type="number" step="0.01" class="mt-1 block w-full" :value="$design->beam_h" required autofocus autocomplete="beam_h" />
                                <x-input-error class="mt-2" :messages="$errors->get('beam_h')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="column_h" :value="__('Column height')" />
                                <x-text-input id="column_h" name="column_h" type="number" step="0.01" class="mt-1 block w-full" :value="$design->column_h" required autofocus autocomplete="column_h" />
                                <x-input-error class="mt-2" :messages="$errors->get('column_h')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="top_plate_h" :value="__('Tie beam height')" />
                                <x-text-input id="top_plate_h" name="top_plate_h" type="number" step="0.01" class="mt-1 block w-full" :value="$design->top_plate_h" required autofocus autocomplete="top_plate_h" />
                                <x-input-error class="mt-2" :messages="$errors->get('top_plate_h')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="long_sill_h" :value="__('Bottom sill height')" />
                                <x-text-input id="long_sill_h" name="long_sill_h" type="number" step="0.01" class="mt-1 block w-full" :value="$design->long_sill_h" required autofocus autocomplete="long_sill_h" />
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

                    <div id="optimizer_result" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
