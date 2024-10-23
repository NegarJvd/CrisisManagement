<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Lets find shelter for you!') }}
            </h2>
        </div>
    </x-slot>

{{--    <script type="module">--}}
{{--        $(document).ready(function() {--}}
{{--            --}}
{{--        })--}}
{{--    </script>--}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status') === 'success')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="bg-green-800 text-white p-4 mt-3 mb-3 rounded-lg dark:text-gray-400"
                >
                    {{ __('Success') }}
                </div>
            @elseif(session('status') === 'error')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="bg-red-800 text-white p-4 mt-3 mb-3 rounded-lg dark:text-gray-400"
                >
                    {{ __('Error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">
                    <div class="w-full mb-2">
                        <div id="map" style="height: 400px"></div>
                    </div>

                    <div class="flex flex-row mb-4">

                        <div class="basis-1/4 mr-2 flex items-center">
                            <span>
                                Choose your location:
                            </span>
                        </div>

                        <div class="basis-1/4 mr-2">
                            <x-input-label for="latitude" :value="__('Latitude')"/>
                            <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full"
                                          :value="$latitude ?? null" required autofocus autocomplete="latitude"/>
                            <x-input-error class="mt-2" :messages="$errors->get('latitude')"/>
                        </div>

                        <div class="basis-1/4 mr-2">
                            <x-input-label for="longitude" :value="__('Longitude')"/>
                            <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full"
                                          :value="$longitude ?? null" required autofocus autocomplete="longitude"/>
                            <x-input-error class="mt-2" :messages="$errors->get('longitude')"/>
                        </div>

{{--                        <div class="basis-1/4 flex items-end mb-1">--}}
{{--                            <x-primary-button>{{ __('Search') }}</x-primary-button>--}}
{{--                        </div>--}}
                    </div>

                    <hr>

                    <div class="flex flex-row mt-4 mb-4" id="timber_providers_div">
                        <div class="basis-1/2 mr-2">
                            <h2 class="mb-2">In range timber providers</h2>
                            <table class="table-auto w-full border-collapse border border-slate-500 text-center" id="timber_provider_table">
                                <thead>
                                    <tr class="border border-slate-600 bg-gray-100 py-3">
                                        <th class="border border-slate-600 py-3">Id</th>
                                        <th class="border border-slate-600 py-3">Name</th>
                                        <th class="border border-slate-600 py-3">Email</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="basis-1/2 ml-2">
                            <h2 class="mb-2">In range supply points</h2>
                            <table class="table-auto w-full border-collapse border border-slate-500 text-center" id="timber_supply_points_table">
                                <thead>
                                    <tr class="border border-slate-600 bg-gray-100 py-3">
                                        <th class="border border-slate-600 py-3">Id</th>
                                        <th class="border border-slate-600 py-3">Range (Km)</th>
                                        <th class="border border-slate-600 py-3">Order</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>

                    <hr>

                    <div class="flex flex-row mt-4 mb-4" id="cnc_providers_div">
                        <div class="basis-1/2 mr-2">
                            <h2 class="mb-2">In range cnc providers</h2>
                            <table class="table-auto w-full border-collapse border border-slate-500 text-center" id="cnc_provider_table">
                                <thead>
                                <tr class="border border-slate-600 bg-gray-100 py-3">
                                    <th class="border border-slate-600 py-3">Id</th>
                                    <th class="border border-slate-600 py-3">Name</th>
                                    <th class="border border-slate-600 py-3">Email</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="basis-1/2 ml-2">
                            <h2 class="mb-2">In range cnc points</h2>
                            <table class="table-auto w-full border-collapse border border-slate-500 text-center" id="cnc_supply_points_table">
                                <thead>
                                <tr class="border border-slate-600 bg-gray-100 py-3">
                                    <th class="border border-slate-600 py-3">Id</th>
                                    <th class="border border-slate-600 py-3">Range (Km)</th>
                                    <th class="border border-slate-600 py-3">Order</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
