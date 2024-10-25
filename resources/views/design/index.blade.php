@php use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Designs') }}
            </h2>

            <div id="create_new_design" class="hidden flex flex-row justify-center text-center">
                <a class="border border-slate-600 p-1 rounded-lg hover:bg-gray-100" href="{{route('design.create.step1')}}">Create
                    new</a>
            </div>
        </div>
    </x-slot>

    <script type="module">
        $(document).ready(function() {
            $('.design_type').on('click', function (){
                alert("Coming soon ...")
            })

            $('#timber_frame').on('click', function (){
                $('#create_new_design').removeClass('hidden')
                $('#design_list').removeClass('hidden')
                $('#design_list_paginate').removeClass('hidden')

                $('#design_types_select').addClass('hidden')
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
                    <div id="design_types_select" class="flex flex-row justify-center mb-6">
                        <div class="basis-1/6 group block max-w-xs mx-auto rounded-lg p-2 mr-2 ml-2 ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-gray-100 hover:ring-gray-100 design_type">
                            <div class="items-center text-center">
                                <h2 class="mt-2 dark:text-gray-100">{{ __('Solid Log Construction') }}</h2>
                            </div>
                        </div>

                        <div class="basis-1/6 group block max-w-xs mx-auto rounded-lg p-2 mr-2 ml-2 ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-gray-100 hover:ring-gray-100 design_type">
                            <div class="items-center text-center">
                                <h2 class="mt-2 dark:text-gray-100">{{ __('Frame Construction') }}</h2>
                            </div>
                        </div>

                        <div id="timber_frame" class="basis-1/6 group block max-w-xs mx-auto rounded-lg p-2 mr-2 ml-2 ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-gray-100 hover:ring-gray-100">
                            <div class="items-center text-center">
                                <h2 class="mt-2 dark:text-gray-100">{{ __('Timber Frame') }}</h2>
                            </div>
                        </div>

                        <div class="basis-2/6 group block max-w-xs mx-auto rounded-lg p-2 mr-2 ml-2 ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-gray-100 hover:ring-gray-100 design_type">
                            <div class="items-center text-center">
                                <h2 class="mt-2 dark:text-gray-100">{{ __('Light Bearing Construction') }}</h2>
                            </div>
                        </div>

                        <div class="basis-1/6 group block max-w-xs mx-auto rounded-lg p-2 mr-2 ml-2 ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-gray-100 hover:ring-gray-100 design_type">
                            <div class="items-center text-center">
                                <h2 class="mt-2 dark:text-gray-100">{{ __('Panel Construction') }}</h2>
                            </div>
                        </div>

                    </div>

                    <table id="design_list" class="hidden table-auto w-full border-collapse border border-slate-500 text-center">
                        <thead>
                        <tr class="border border-slate-600 bg-gray-100 py-3">
                            <th class="border border-slate-600 py-3">Id</th>
                            <th class="border border-slate-600 py-3">Designer</th>
                            <th class="border border-slate-600 py-3">Woods</th>
                            <th class="border border-slate-600 py-3">Footprint</th>
                            <th class="border border-slate-600 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($designs as $design)
                            <tr class="border border-slate-600 py-3">
                                <td class="border border-slate-600 py-3">{{$design->id}}</td>
                                <td class="border border-slate-600 py-3">{{$design->user->name}}</td>
                                <td class="border border-slate-600 py-3">
                                    {{implode(' , ', $design->woods()->pluck('name')->toArray())}}
                                </td>
                                <td class="border border-slate-600 py-3">
                                    width: {{$design->width}} , length: {{$design->length}} , height: {{$design->height}} , slab_thickness: {{$design->slab_thickness}} , column_number: {{$design->column_number}}
                                </td>
                                <td class="py-3 flex flex-row items-center justify-center">
{{--                                    <div class="basis-1/2 flex items-center justify-center">--}}
{{--                                        <a href="{{route('design.fork', $design->id)}}" title="fork">--}}
{{--                                            <img class="w-4 hover:bg-gray-300" src="{{asset('/icons/fork.png')}}"--}}
{{--                                                 alt="fork">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}

                                    <div class="basis-1/2 flex items-center justify-center">
                                        <a href="{{route('design.show', $design->id)}}" title="show details">
                                            <img class="w-4 hover:bg-gray-300" src="{{asset('/icons/show.png')}}" alt="show">
                                        </a>
                                    </div>

                                    @if(Auth::user()->is_admin or $design->user_id == Auth::id())
{{--                                        <div class="basis-1/2 flex items-center justify-center">--}}
{{--                                            <a href="{{route('design.edit', $design->id)}}" title="edit">--}}
{{--                                                <img class="w-4 hover:bg-gray-300" src="{{asset('/icons/edit.png')}}"--}}
{{--                                                     alt="edit">--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
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

                    <div id="design_list_paginate" class="hidden mt-3">
                        {{$designs->links()}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
