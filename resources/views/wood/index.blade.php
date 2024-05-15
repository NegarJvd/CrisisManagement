@php use App\Enums\WoodTypeEnum; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Wood Management') }}
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
                    <form method="post" action="{{ route('wood-management.store') }}" class="flex flex-row">
                        @csrf

                        <div class="basis-1/6 mr-2 flex items-center">
                            <span>
                                Add new Wood
                            </span>
                        </div>

                        <div class="basis-1/4 mr-2">
                            <x-input-label for="name" :value="__('Name')"/>
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                          :value="old('name')" required autofocus autocomplete="name"/>
                            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                        </div>

                        <div class="basis-1/4 mr-2">
                            <x-input-label for="type" :value="__('Type')"/>
                            <x-select id="type" name="type" class="mt-1 block w-full" required autofocus
                                      autocomplete="type">
                                <option></option>
                                @foreach(WoodTypeEnum::cases() as $type)
                                    <option value="{{$type->value}}"
                                            @if(old('type') == $type->value) selected @endif>{{$type->value}}</option>
                                @endforeach
                            </x-select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')"/>
                        </div>

                        <div class="basis-1/4 flex items-end mb-1">
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
                            <th class="border border-slate-600 py-3">type</th>
                            <th class="border border-slate-600 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($woods as $wood)
                            <tr class="border border-slate-600 py-3">
                                <td class="border border-slate-600 py-3">{{$wood->id}}</td>
                                <td class="border border-slate-600 py-3">{{$wood->name}}</td>
                                <td class="border border-slate-600 py-3">{{$wood->type}}</td>
                                <td class="py-3 flex flex-row items-center justify-center">
                                    <div class="basis-1/2 flex items-center justify-center">
                                        <x-button
                                            x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'edit-wood-{{$wood->id}}')"
                                        >
                                            <img class="w-4 hover:bg-gray-300" src="{{asset('/icons/edit.png')}}"
                                                 alt="edit">
                                        </x-button>

                                        <x-modal name="edit-wood-{{$wood->id}}" focusable>
                                            <form method="post" action="{{ route('wood-management.update', $wood->id) }}" class="p-6">
                                                @csrf
                                                @method('put')

                                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                    {{ __('Update wood '.$wood->name) }}
                                                </h2>

                                                <div class="mt-6 flex flex-row">
                                                    <div class="basis-1/3 mr-2">
                                                        <x-input-label for="name" :value="__('Name')"/>
                                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                                                      :value="$wood->name" required autofocus autocomplete="name"/>
                                                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                                    </div>

                                                    <div class="basis-1/3 mr-2">
                                                        <x-input-label for="type" :value="__('Type')"/>
                                                        <x-select id="type" name="type" class="mt-1 block w-full" required autofocus autocomplete="type">
                                                            @foreach(WoodTypeEnum::cases() as $type)
                                                                <option value="{{$type->value}}" @if($wood->type->value == $type->value) selected @endif>
                                                                    {{$type->value}}
                                                                </option>
                                                            @endforeach
                                                        </x-select>
                                                        <x-input-error class="mt-2" :messages="$errors->get('type')"/>
                                                    </div>

                                                    <div class="basis-1/3 flex items-end mb-1">
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
                                        <form method="post" action="{{ route('wood-management.destroy', $wood->id) }}"
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
                        {{$woods->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
