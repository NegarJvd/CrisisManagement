<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Suggest design') }}
            </h2>
        </div>
    </x-slot>

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

                    <form method="post" action="{{ route('suggest') }}" class="flex flex-row">
                        @csrf

                        <div class="basis-1/4 mr-2 flex items-center">
                            <span>
                                Search for best designs for your location and condition:
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

                        <div class="basis-1/4 mr-2">
                            <x-input-label for="number_of_households" :value="__('Number of households')"/>
                            <x-text-input id="number_of_households" name="number_of_households" type="text" class="mt-1 block w-full"
                                          :value="$number_of_households ?? null" required autofocus autocomplete="number_of_households"/>
                            <x-input-error class="mt-2" :messages="$errors->get('number_of_households')"/>
                        </div>

                        <div class="basis-1/4 flex items-end mb-1">
                            <x-primary-button>{{ __('Search') }}</x-primary-button>
                        </div>
                    </form>
                </div>

                <hr>

                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">
                    <table class="table-auto w-full border-collapse border border-slate-500 text-center">
                        <thead>
                        <tr class="border border-slate-600 bg-gray-100 py-3">
                            <th class="border border-slate-600 py-3">Id</th>
                            <th class="border border-slate-600 py-3">Woods</th>
                            <th class="border border-slate-600 py-3">Machines</th>
                            <th class="border border-slate-600 py-3">Snow load</th>
                            <th class="border border-slate-600 py-3">Wind load</th>
                            <th class="border border-slate-600 py-3">Earthquake load</th>
                            <th class="border border-slate-600 py-3">Number of households</th>
                            <th class="border border-slate-600 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @isset($designs)
                            @foreach($designs as $design)
                                <tr class="border border-slate-600 py-3">
                                    <td class="border border-slate-600 py-3">{{$design->id}}</td>
                                    <td class="border border-slate-600 py-3">
                                        @foreach($design->woods as $wood)
                                            <span>[{{$wood->name}}]</span>
                                        @endforeach
                                    </td>
                                    <td class="border border-slate-600 py-3">
                                        @foreach($design->machines as $machine)
                                            <span>[{{$machine->name}}]</span>
                                        @endforeach
                                    </td>
                                    <td class="border border-slate-600 py-3">{{$design->snow_load}}</td>
                                    <td class="border border-slate-600 py-3">{{$design->wind_load}}</td>
                                    <td class="border border-slate-600 py-3">{{$design->earthquake_load}}</td>
                                    <td class="border border-slate-600 py-3">{{$design->number_of_households}}</td>
                                    <td class="py-3 flex flex-row items-center justify-center">
                                        <a href="{{route('design.show', ['design' => $design->id, 'latitude' => $latitude ?? null, 'longitude' => $longitude ?? null])}}">
                                            <img class="w-8 hover:bg-gray-300" src="{{asset('/icons/show.png')}}" alt="show">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset

                        </tbody>
                    </table>

                    {{--                    <div class="mt-3">--}}
                    {{--                        @isset($designs)--}}
                    {{--                            {{$designs->links()}}--}}
                    {{--                        @endisset--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
