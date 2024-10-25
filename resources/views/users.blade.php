<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User Management') }}
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
                            <th class="border border-slate-600 py-3">Name</th>
                            <th class="border border-slate-600 py-3">Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="border border-slate-600 py-3 @if($user->is_admin) text-fuchsia-950 font-bold bg-gray-100 @endif">
                                <td class="border border-slate-600 py-3">{{$user->id}}</td>
                                <td class="border border-slate-600 py-3">{{$user->name}}</td>
                                <td class="border border-slate-600 py-3">{{$user->email}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{$users->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
