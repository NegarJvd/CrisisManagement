<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Designs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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
                            @foreach($designs as $design)
                                <tr class="border border-slate-600 py-3">
                                    <td class="border border-slate-600 py-3">{{$design->id}}</td>
                                    <td class="border border-slate-600 py-3">Woods</td>
                                    <td class="border border-slate-600 py-3">Machines</td>
                                    <td class="border border-slate-600 py-3">{{$design->snow_load}}</td>
                                    <td class="border border-slate-600 py-3">{{$design->wind_load}}</td>
                                    <td class="border border-slate-600 py-3">{{$design->earthquake_load}}</td>
                                    <td class="border border-slate-600 py-3">{{$design->number_of_households}}</td>
                                    <td class="flex flex-row">
                                        <div class="basis-1/2 text-center">
                                            <img class="w-6" src="{{asset('/icons/designer.png')}}" alt="Designer Dashboard">
                                        </div>
                                        <div class="basis-1/2">
                                            <img class="w-6" src="{{asset('/icons/designer.png')}}" alt="Designer Dashboard">
                                        </div>

                                    </td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
