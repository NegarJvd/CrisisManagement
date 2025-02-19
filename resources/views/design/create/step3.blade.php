<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Design') }}
        </h2>
    </x-slot>

    <script type="module">
        $(document).ready(function () {
            $('#load_calculator').on('click', function () {
                const url = "{!! env('FLASK_URL') !!}" + '/load_calculator';

                $.ajax({
                    url: url,
                    type: 'POST',
                    async: true,
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "footprint": {
                            "column_number": parseFloat("{{$design->column_number}}"),
                            "height": parseFloat("{{$design->height}}"),
                            "length": parseFloat("{{$design->length}}"),
                            "slab_thickness": parseFloat("{{$design->slab_thickness}}"),
                            "width": parseFloat("{{$design->width}}")
                        },
                        "material": {
                            "density": parseFloat("{{$wood_model->density}}")
                        }
                    }),
                    success: function (data, textStatus, jQxhr) {
                        const response = JSON.parse(jQxhr.responseText);

                        let load_calculator_json_values = {}

                        const load_calculator_result = document.getElementById('load_calculator_result')
                        load_calculator_result.innerHTML = ""

                        let load_calculator_values_as_string = ""

                        $("#dead_load").val(response.gk.value).change()
                        $("#wind_load").val(response.wk.value).change()
                        // Iterate over all the keys in the object
                        for (let key in response) {
                            if (typeof response[key] === 'object') {
                                if (response[key].print_value) {
                                    // Create a paragraph element and add the print_value
                                    const p = document.createElement('p');
                                    p.textContent = response[key].print_value;
                                    load_calculator_result.appendChild(p);

                                    load_calculator_values_as_string += response[key].print_value + "<br>"
                                }
                                if (response[key].value) {
                                    load_calculator_json_values[key] = response[key].value
                                }
                            }
                            // Handle nested objects (like wind_direct and wind_side)
                            if (typeof response[key] === 'object') {
                                for (let subKey in response[key]) {
                                    if (response[key][subKey].print_value) {
                                        const p = document.createElement('p');
                                        p.textContent = response[key][subKey].print_value;
                                        load_calculator_result.appendChild(p);

                                        load_calculator_values_as_string += response[key][subKey].print_value + "<br>"
                                    }
                                }
                            }
                        }

                        $('#load_calculator_values_as_string').val(load_calculator_values_as_string).change();
                        $('#load_calculator_values_as_object').val(JSON.stringify(load_calculator_json_values)).change();
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

            @if (session('success') !== null)
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="bg-green-800 text-white p-4 mt-3 mb-3 rounded-lg dark:text-gray-400"
                >
                    {{ session('success') }}
                </div>
            @elseif(session('error') !== null)
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="bg-red-800 text-white p-4 mt-3 mb-3 rounded-lg dark:text-gray-400"
                >
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">

                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div
                            class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                            style="width: 60%"> 60%
                        </div>
                    </div>

                    <form method="post" action="{{ route('design.store.step3') }}" class="mt-6 space-y-6"
                          enctype="multipart/form-data">
                        @csrf

                        <h2>
                            Enter loading actions or use {{__('Load calculator')}}:
                        </h2>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="snow_load" :value="__('Snow Load')"/>
                                <x-text-input id="snow_load" name="snow_load" type="number" step="0.01"
                                              class="mt-1 block w-full" :value="$snow_load" autofocus
                                              autocomplete="snow_load"/>
                                <x-input-error class="mt-2" :messages="$errors->get('snow_load')"/>
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="wind_load" :value="__('Wind load')"/>
                                <x-text-input id="wind_load" name="wind_load" type="number" step="0.01"
                                              class="mt-1 block w-full" :value="$wind_load" autofocus
                                              autocomplete="wind_load"/>
                                <x-input-error class="mt-2" :messages="$errors->get('wind_load')"/>
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="dead_load" :value="__('Dead load')"/>
                                <x-text-input id="dead_load" name="dead_load" type="number" step="0.01"
                                              class="mt-1 block w-full" :value="$dead_load" autofocus
                                              autocomplete="dead_load"/>
                                <x-input-error class="mt-2" :messages="$errors->get('dead_load')"/>
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="live_load" :value="__('Live load')"/>
                                <x-text-input id="live_load" name="live_load" type="number" step="0.01"
                                              class="mt-1 block w-full" :value="$live_load" autofocus
                                              autocomplete="live_load"/>
                                <x-input-error class="mt-2" :messages="$errors->get('live_load')"/>
                            </div>
                        </div>

                        <div class="w-full mb-2">
                            <div id="map" style="height: 400px"></div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <h2>
                                    Choose your coordinate on map:
                                </h2>
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="latitude" :value="__('Latitude')" />
                                <x-text-input readonly id="latitude" name="latitude" type="text" class="mt-1 block w-full" :value="old('latitude')" required autofocus autocomplete="latitude" />
                                <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="longitude" :value="__('Longitude')" />
                                <x-text-input readonly id="longitude" name="longitude" type="text" class="mt-1 block w-full" :value="old('longitude')" required autofocus autocomplete="longitude" />
                                <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                            </div>
                        </div>

                        <textarea id="load_calculator_values_as_string" name="load_calculator_values_as_string" class="hidden">{{$load_calculator_values_as_string}}</textarea>

                        <x-text-input id="load_calculator_values_as_object" name="load_calculator_values_as_object" type="text"
                                      class="hidden" :value="$load_calculator_values_as_object"/>

                        <div class="flex items-center gap-4">
                            <a href="{{route('design.create.step2')}}">
                                <x-secondary-button>{{__('Previous')}}</x-secondary-button>
                            </a>

                            <x-primary-button>{{ __('Save and next') }}</x-primary-button>

                            <x-secondary-button id="load_calculator">{{__('Load calculator')}}</x-secondary-button>
                        </div>
                    </form>

                    <div id="load_calculator_result" class="mt-4"></div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
