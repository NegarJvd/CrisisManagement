<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Design Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">
                    <div class="flex flex-row mb-2">
                        <div class="basis-1/2 mr-2 flex flex-row">
                            <div class="mr-2">
                                {{__('File of design')}} :
                            </div>
                            @if($design->file_path)
                                <a href="{{route('design.download_file', $design->id)}}" title="download" download=>
                                    <img class="w-8 hover:bg-gray-300" src="{{asset('/icons/file.png')}}" alt="download">
                                </a>
                            @endif
                        </div>

                        <div class="basis-1/2 ml-2 flex flex-row">
                            <div class="mr-2">
                                {{__('Number of households')}} :
                            </div>
                            <div class="justify-start">
                                {{$design->number_of_households}}
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row mb-2">
                        <div class="basis-1/3 mr-2 flex flex-row">
                            <div class="mr-2">
                                {{__('Snow load')}} :
                            </div>
                            <div class="justify-start">
                                {{$design->snow_load}}
                            </div>
                        </div>
                        <div class="basis-1/3 mr-2 flex flex-row">
                            <div class="mr-2">
                                {{__('Wind load')}} :
                            </div>
                            <div class="justify-start">
                                {{$design->wind_load}}
                            </div>
                        </div>
                        <div class="basis-1/3 mr-2 flex flex-row">
                            <div class="mr-2">
                                {{__('Earthquake load')}} :
                            </div>
                            <div class="justify-start">
                                {{$design->earthquake_load}}
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="mt-2 flex flex-row">
                        <div class="basis-1/2 mr-2">
                            <div class="mb-2">
                                <h3 class="font-bold">
                                    Wood list and in range Timber supplies
                                </h3>
                                <small>
                                    {{implode(',', $design->woods()->pluck('name')->toArray())}}
                                </small>
                            </div>

                            <table class="table-auto w-full border-collapse border border-slate-500 text-center">
                                <thead>
                                <tr class="border border-slate-600 bg-gray-100 py-3">
                                    <th class="border border-slate-600 py-3">Timber Supply</th>
                                    <th class="border border-slate-600 py-3">Wood</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($timber_in_range as $timber)
                                    <tr class="border border-slate-600 py-3">
                                        <td class="border border-slate-600 py-3 timber_name">
                                            {{$timber->user->name}}
                                        </td>
                                        <td class="border border-slate-600 py-3">
                                            @foreach($timber->woods as $wood)
                                                @if(in_array($wood->id, $design->woods()->pluck('id')->toArray()))
                                                    <span>[{{$wood->name}}]</span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td hidden="hidden">
                                            <input class="timber_lat" hidden="hidden" value="{{$timber->latitude ?? null}}" type="text">
                                            <input class="timber_lon" hidden="hidden" value="{{$timber->longitude ?? null}}" type="text">
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="basis-1/2 ml-2">
                            <div class="mb-2">
                                <h3 class="font-bold">
                                    Machines list and in range CNC Supplies
                                </h3>
                                <small>
                                    {{implode(',', $design->machines()->pluck('name')->toArray())}}
                                </small>
                            </div>

                            <table class="table-auto w-full border-collapse border border-slate-500 text-center">
                                <thead>
                                <tr class="border border-slate-600 bg-gray-100 py-3">
                                    <th class="border border-slate-600 py-3">CNC Supply</th>
                                    <th class="border border-slate-600 py-3">Machines</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($cnc_in_range as $cnc)
                                    <tr class="border border-slate-600 py-3">
                                        <td class="border border-slate-600 py-3 cnc_name">
                                            {{$cnc->user->name}}
                                        </td>
                                        <td class="border border-slate-600 py-3">
                                            @foreach($cnc->machines as $machine)
                                                @if(in_array($machine->id, $design->machines()->pluck('id')->toArray()))
                                                    <span>[{{$machine->name}}]</span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td hidden="hidden">
                                            <input class="cnc_lat" hidden="hidden" value="{{$cnc->latitude ?? null}}" type="text">
                                            <input class="cnc_lon" hidden="hidden" value="{{$cnc->longitude ?? null}}" type="text">
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <input id="crisis_lat" hidden="hidden" value="{{$latitude ?? null}}" type="text">
                        <input id="crisis_lon" hidden="hidden" value="{{$longitude ?? null}}" type="text">

                        <div id="map" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
