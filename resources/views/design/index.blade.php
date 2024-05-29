@php use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Designs') }}
            </h2>

            <div class="flex flex-row justify-center text-center">
                <a class="border border-slate-600 p-1 rounded-lg hover:bg-gray-100" href="{{route('design.create')}}">Create
                    new</a>
            </div>
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
                                    <div class="basis-1/2 flex items-center justify-center">
                                        <a href="{{route('design.fork', $design->id)}}" title="fork">
                                            <img class="w-4 hover:bg-gray-300" src="{{asset('/icons/fork.png')}}"
                                                 alt="fork">
                                        </a>
                                    </div>
                                    @if(Auth::user()->is_admin or $design->user_id == Auth::id())
                                        <div class="basis-1/2 flex items-center justify-center">
                                            <a href="{{route('design.edit', $design->id)}}" title="edit">
                                                <img class="w-4 hover:bg-gray-300" src="{{asset('/icons/edit.png')}}"
                                                     alt="edit">
                                            </a>
                                        </div>
                                        <div class="basis-1/2 flex items-center justify-center">
                                            <form method="post" action="{{ route('design.destroy', $design->id) }}"
                                                  title="delete">
                                                @csrf
                                                @method('delete')
                                                <button type="submit">
                                                    <img class="w-4 hover:bg-gray-300"
                                                         src="{{asset('/icons/delete.png')}}" alt="delete">
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{$designs->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
