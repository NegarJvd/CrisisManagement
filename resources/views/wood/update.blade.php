@php use App\Enums\WoodTypeEnum; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update material') }}
        </h2>
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
                    <form method="post" action="{{ route('wood-management.update', $wood->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $wood->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="type" :value="__('Type')"/>
                                <x-select id="type" name="type" class="mt-1 block w-full" required autofocus
                                          autocomplete="type">
                                    <option></option>
                                    @foreach(WoodTypeEnum::cases() as $type)
                                        <option value="{{$type->value}}"
                                                @if(old('type') ==  $type->value or $wood->type->value == $type->value) selected @endif>
                                            {{$type->value}}
                                        </option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('type')"/>
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="bending_strength" :value="__('Bending strength')" />
                                <x-text-input id="bending_strength" name="bending_strength" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('bending_strength', $wood->bending_strength)" required autofocus autocomplete="bending_strength" />
                                <x-input-error class="mt-2" :messages="$errors->get('bending_strength')" />
                            </div>

                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="tension_parallel" :value="__('Tension strength parallel to grain')" />
                                <x-text-input id="tension_parallel" name="tension_parallel" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('tension_parallel', $wood->tension_parallel)" required autofocus autocomplete="tension_parallel" />
                                <x-input-error class="mt-2" :messages="$errors->get('tension_parallel')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="tension_perpendicular" :value="__('Tension strength perpendicular to grain')" />
                                <x-text-input id="tension_perpendicular" name="tension_perpendicular" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('tension_perpendicular', $wood->tension_perpendicular)" required autofocus autocomplete="tension_perpendicular" />
                                <x-input-error class="mt-2" :messages="$errors->get('tension_perpendicular')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="compression_parallel" :value="__('Compression strength parallel to grain')" />
                                <x-text-input id="compression_parallel" name="compression_parallel" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('compression_parallel', $wood->compression_parallel)" required autofocus autocomplete="compression_parallel" />
                                <x-input-error class="mt-2" :messages="$errors->get('compression_parallel')" />

                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="compression_perpendicular" :value="__('Compression strength perpendicular to grain ')" />
                                <x-text-input id="compression_perpendicular" name="compression_perpendicular" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('compression_perpendicular', $wood->compression_perpendicular)" required autofocus autocomplete="compression_perpendicular" />
                                <x-input-error class="mt-2" :messages="$errors->get('compression_perpendicular')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="e_modulus_5" :value="__('E-modulus 5%')" />
                                <x-text-input id="e_modulus_5" name="e_modulus_5" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('e_modulus_5', $wood->e_modulus_5)" required autofocus autocomplete="e_modulus_5" />
                                <x-input-error class="mt-2" :messages="$errors->get('e_modulus_5')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="e_modulus" :value="__('E-modulus')" />
                                <x-text-input id="e_modulus" name="e_modulus" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('e_modulus', $wood->e_modulus)" required autofocus autocomplete="e_modulus" />
                                <x-input-error class="mt-2" :messages="$errors->get('e_modulus')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="partial_factor" :value="__('Partial factor')" />
                                <x-text-input id="partial_factor" name="partial_factor" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('partial_factor', $wood->partial_factor)" required autofocus autocomplete="partial_factor" />
                                <x-input-error class="mt-2" :messages="$errors->get('partial_factor')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="shear_strength" :value="__('Shear strength')" />
                                <x-text-input id="shear_strength" name="shear_strength" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('shear_strength', $wood->shear_strength)" required autofocus autocomplete="shear_strength" />
                                <x-input-error class="mt-2" :messages="$errors->get('shear_strength')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="density" :value="__('Density')" />
                                <x-text-input id="density" name="density" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('density', $wood->density)" required autofocus autocomplete="density" />
                                <x-input-error class="mt-2" :messages="$errors->get('density')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="modification_factor_permanent_term" :value="__('Modification factor permanent term')" />
                                <x-text-input id="modification_factor_permanent_term" name="modification_factor_permanent_term" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('modification_factor_permanent_term', $wood->modification_factor_permanent_term)" required autofocus autocomplete="modification_factor_permanent_term" />
                                <x-input-error class="mt-2" :messages="$errors->get('modification_factor_permanent_term')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="modification_factor_medium_term" :value="__('Modification factor medium term')" />
                                <x-text-input id="modification_factor_medium_term" name="modification_factor_medium_term" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('modification_factor_medium_term', $wood->modification_factor_medium_term)" required autofocus autocomplete="modification_factor_medium_term" />
                                <x-input-error class="mt-2" :messages="$errors->get('modification_factor_medium_term')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="modification_factor_instantaneous_term" :value="__('Modification factor instantaneous term')" />
                                <x-text-input id="modification_factor_instantaneous_term" name="modification_factor_instantaneous_term" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('modification_factor_instantaneous_term', $wood->modification_factor_instantaneous_term)" required autofocus autocomplete="modification_factor_instantaneous_term" />
                                <x-input-error class="mt-2" :messages="$errors->get('modification_factor_instantaneous_term')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="creep_factor" :value="__('Creep factor')" />
                                <x-text-input id="creep_factor" name="creep_factor" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('creep_factor', $wood->creep_factor)" required autofocus autocomplete="creep_factor" />
                                <x-input-error class="mt-2" :messages="$errors->get('creep_factor')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="creep_factor_solid_timber" :value="__('Creep factor solid timber')" />
                                <x-text-input id="creep_factor_solid_timber" name="creep_factor_solid_timber" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('creep_factor_solid_timber', $wood->creep_factor_solid_timber)" required autofocus autocomplete="creep_factor_solid_timber" />
                                <x-input-error class="mt-2" :messages="$errors->get('creep_factor_solid_timber')" />
                            </div>
                            <div class="basis-1/3 ml-2">
                                <x-input-label for="dtl_e" :value="__('End distance requirement')" />
                                <x-text-input id="dtl_e" name="dtl_e" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('dtl_e', $wood->dtl_e)" required autofocus autocomplete="dtl_e" />
                                <x-input-error class="mt-2" :messages="$errors->get('dtl_e')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="dtl_g" :value="__('Vertical edge distance requirement')" />
                                <x-text-input id="dtl_g" name="dtl_g" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('dtl_g', $wood->dtl_g)" required autofocus autocomplete="dtl_g" />
                                <x-input-error class="mt-2" :messages="$errors->get('dtl_g')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="dtl_s" :value="__('Peg spacing distance requirement')" />
                                <x-text-input id="dtl_s" name="dtl_s" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('dtl_s', $wood->dtl_s)" required autofocus autocomplete="dtl_s" />
                                <x-input-error class="mt-2" :messages="$errors->get('dtl_s')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="dtl_v" :value="__('Edge distance requirement')" />
                                <x-text-input id="dtl_v" name="dtl_v" type="number" step="0.1" step="0.1" class="mt-1 block w-full" :value="old('dtl_v', $wood->dtl_v)" required autofocus autocomplete="dtl_v" />
                                <x-input-error class="mt-2" :messages="$errors->get('dtl_v')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
