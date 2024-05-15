<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Machine Management') }}
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
                    <form method="post" action="{{ route('machine-management.store') }}" class="flex flex-row">
                        @csrf

                        <div class="basis-1/6 mr-2 flex items-center">
                            <span>
                                Add new Machine
                            </span>
                        </div>

                        <div class="basis-1/2 mr-2">
                            <x-input-label for="name" :value="__('Name')"/>
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                          :value="old('name')" required autofocus autocomplete="name"/>
                            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                        </div>

                        <div class="basis-1/2 flex items-end mb-1">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>

                <hr>

                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">
                    <table class="table-auto w-full border-collapse border border-slate-500 text-center">
                        <thead>
                        <tr class="border border-slate-600 bg-gray-100 py-3">
                            <th class="border border-slate-600 py-3">Id</th>
                            <th class="border border-slate-600 py-3">name</th>
                            <th class="border border-slate-600 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($machines as $machine)
                            <tr class="border border-slate-600 py-3">
                                <td class="border border-slate-600 py-3">{{$machine->id}}</td>
                                <td class="border border-slate-600 py-3">{{$machine->name}}</td>
                                <td class="py-3 flex flex-row items-center justify-center">
                                    <div class="basis-1/2 flex items-center justify-center">
                                        <x-button
                                            x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'edit-machine-{{$machine->id}}')"
                                        >
                                            <img class="w-4 hover:bg-gray-300" src="{{asset('/icons/edit.png')}}"
                                                 alt="edit">
                                        </x-button>

                                        <x-modal name="edit-machine-{{$machine->id}}" focusable>
                                            <form method="post" action="{{ route('machine-management.update', $machine->id) }}" class="p-6">
                                                @csrf
                                                @method('put')

                                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                    {{ __('Update machine '.$machine->name) }}
                                                </h2>

                                                <div class="mt-6 flex flex-row">
                                                    <div class="basis-1/2 mr-2">
                                                        <x-input-label for="name" :value="__('Name')"/>
                                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                                                      :value="$machine->name" required autofocus autocomplete="name"/>
                                                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                                    </div>

                                                    <div class="basis-1/2 flex items-end mb-1">
                                                        <x-primary-button>
                                                            {{ __('Update') }}
                                                        </x-primary-button>
                                                        <x-secondary-button x-on:click="$dispatch('close')" class="ms-3">
                                                            {{ __('Cancel') }}
                                                        </x-secondary-button>
                                                    </div>
                                                </div>
                                            </form>
                                        </x-modal>

                                    </div>
                                    <div class="basis-1/2 flex items-center justify-center">
                                        <form method="post" action="{{ route('machine-management.destroy', $machine->id) }}"
                                              title="delete">
                                            @csrf
                                            @method('delete')
                                            <button type="submit">
                                                <img class="w-4 hover:bg-gray-300" src="{{asset('/icons/delete.png')}}"
                                                     alt="delete">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{$machines->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
