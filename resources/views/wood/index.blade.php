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
                    <form method="post" action="{{ route('wood-management.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <h2>
                            Add new Wood
                        </h2>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
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

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="bending_strength" :value="__('Bending strength')" />
                                <x-text-input id="bending_strength" name="bending_strength" type="number" class="mt-1 block w-full" :value="old('bending_strength')" required autofocus autocomplete="bending_strength" />
                                <x-input-error class="mt-2" :messages="$errors->get('bending_strength')" />
                            </div>

                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="tension_parallel" :value="__('Tension strength parallel to grain')" />
                                <x-text-input id="tension_parallel" name="tension_parallel" type="number" class="mt-1 block w-full" :value="old('tension_parallel')" required autofocus autocomplete="tension_parallel" />
                                <x-input-error class="mt-2" :messages="$errors->get('tension_parallel')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="tension_perpendicular" :value="__('Tension strength perpendicular to grain')" />
                                <x-text-input id="tension_perpendicular" name="tension_perpendicular" type="number" class="mt-1 block w-full" :value="old('tension_perpendicular')" required autofocus autocomplete="tension_perpendicular" />
                                <x-input-error class="mt-2" :messages="$errors->get('tension_perpendicular')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="compression_parallel" :value="__('Compression strength parallel to grain')" />
                                <x-text-input id="compression_parallel" name="compression_parallel" type="number" class="mt-1 block w-full" :value="old('compression_parallel')" required autofocus autocomplete="compression_parallel" />
                                <x-input-error class="mt-2" :messages="$errors->get('compression_parallel')" />

                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="compression_perpendicular" :value="__('Compression strength perpendicular to grain ')" />
                                <x-text-input id="compression_perpendicular" name="compression_perpendicular" type="number" class="mt-1 block w-full" :value="old('compression_perpendicular')" required autofocus autocomplete="compression_perpendicular" />
                                <x-input-error class="mt-2" :messages="$errors->get('compression_perpendicular')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="shear_strength" :value="__('Shear strength')" />
                                <x-text-input id="shear_strength" name="shear_strength" type="number" class="mt-1 block w-full" :value="old('shear_strength')" required autofocus autocomplete="shear_strength" />
                                <x-input-error class="mt-2" :messages="$errors->get('shear_strength')" />
                            </div>

                            <div class="basis-1/3  ml-2">
                                <x-input-label for="e_modulus" :value="__('E-modulus')" />
                                <x-text-input id="e_modulus" name="e_modulus" type="number" class="mt-1 block w-full" :value="old('e_modulus')" required autofocus autocomplete="e_modulus" />
                                <x-input-error class="mt-2" :messages="$errors->get('e_modulus')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
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
                            @if(Auth::user()->is_admin)
                                <th class="border border-slate-600 py-3">Actions</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($woods as $wood)
                            <tr class="border border-slate-600 py-3">
                                <td class="border border-slate-600 py-3">{{$wood->id}}</td>
                                <td class="border border-slate-600 py-3">{{$wood->name}}</td>
                                <td class="border border-slate-600 py-3">{{$wood->type}}</td>
                                @if(Auth::user()->is_admin)
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
                                @endif
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
