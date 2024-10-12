<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Design') }}
        </h2>
    </x-slot>

    <script type="module">
        $(document).ready(function() {
            $('#load_calculator').on('click', function (){
                $('#calculator_div').removeClass('hidden')
            })
        })
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">

                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 60%"> 60%</div>
                    </div>

                    <form method="post" action="{{ route('design.store.step3') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <h2>
                            Enter loading actions:
                        </h2>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="snow_load" :value="__('Snow Load')" />
                                <x-text-input id="snow_load" name="snow_load" type="number" step="0.1" class="mt-1 block w-full" :value="$snow_load" autofocus autocomplete="snow_load" />
                                <x-input-error class="mt-2" :messages="$errors->get('snow_load')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="wind_load" :value="__('Wind load')" />
                                <x-text-input id="wind_load" name="wind_load" type="number" step="0.1" class="mt-1 block w-full" :value="$wind_load" autofocus autocomplete="wind_load" />
                                <x-input-error class="mt-2" :messages="$errors->get('wind_load')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="dead_load" :value="__('Dead load')" />
                                <x-text-input id="dead_load" name="dead_load" type="number" step="0.1" class="mt-1 block w-full" :value="$dead_load" autofocus autocomplete="dead_load" />
                                <x-input-error class="mt-2" :messages="$errors->get('dead_load')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="live_load" :value="__('Live load')" />
                                <x-text-input id="live_load" name="live_load" type="number" step="0.1" class="mt-1 block w-full" :value="$live_load" autofocus autocomplete="live_load" />
                                <x-input-error class="mt-2" :messages="$errors->get('live_load')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{route('design.create.step2')}}">
                                <x-secondary-button>{{__('Previous')}}</x-secondary-button>
                            </a>

                            <x-primary-button>{{ __('Save and next') }}</x-primary-button>

                            <x-secondary-button id="load_calculator">{{__('Load calculator')}}</x-secondary-button>
                        </div>
                    </form>

                    <div id="calculator_div" class="mt-6 space-y-6 hidden">
                        <div class="w-full mb-2">
                            <div id="map" style="height: 400px"></div>
                        </div>

                        <div class="flex flex-row hidden">
                            <div class="basis-1/4 mr-2">
                                <x-input-label for="latitude" :value="__('Latitude')"/>
                                <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full"
                                              :value="$latitude ?? null" autofocus autocomplete="latitude"/>
                                <x-input-error class="mt-2" :messages="$errors->get('latitude')"/>
                            </div>

                            <div class="basis-1/4 mr-2">
                                <x-input-label for="longitude" :value="__('Longitude')"/>
                                <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full"
                                              :value="$longitude ?? null" autofocus autocomplete="longitude"/>
                                <x-input-error class="mt-2" :messages="$errors->get('longitude')"/>
                            </div>
                        </div>

                        <div class="mt-2" id="load_calculator_result"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
