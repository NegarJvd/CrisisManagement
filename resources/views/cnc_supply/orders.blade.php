<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('CNC Supply Orders') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">
                    <table class="table-auto w-full border-collapse border border-slate-500 text-center">
                        <thead>
                        <tr class="border border-slate-600 bg-gray-100 py-3">
                            <th class="border border-slate-600 py-3">Id</th>
                            <th class="border border-slate-600 py-3">Customer</th>
                            <th class="border border-slate-600 py-3">Designer</th>
                            <th class="border border-slate-600 py-3">Woods</th>
                            <th class="border border-slate-600 py-3">Order Date</th>
                            <th class="border border-slate-600 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($orders as $order)
                            <tr class="border border-slate-600 py-3">
                                <td class="border border-slate-600 py-3">{{$order->id}}</td>
                                <td class="border border-slate-600 py-3">{{$order->user->email}}</td>
                                <td class="border border-slate-600 py-3">{{$order->design->user->name}}</td>
                                <td class="border border-slate-600 py-3">
                                    {{implode(' , ', $order->design->woods()->pluck('name')->toArray())}}
                                </td>
                                <td class="border border-slate-600 py-3">
                                    {{$order->created_at}}
                                </td>
                                <td class="py-3 flex flex-row items-center justify-center">

                                    <div class="basis-1/2 flex items-center justify-center">
                                        <a href="{{route('design.show', $order->design->id)}}" title="show details">
                                            <img class="w-4 hover:bg-gray-300" src="{{asset('/icons/show.png')}}" alt="show">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{$orders->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
