<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create CNC Supply') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">
                    <form method="post" action="{{ route('cnc-supply.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div class="w-full">
                            <div id="map" style="height: 400px"></div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="latitude" :value="__('Latitude')" />
                                <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full" :value="old('latitude')" required autofocus autocomplete="latitude" />
                                <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="longitude" :value="__('Longitude')" />
                                <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full" :value="old('longitude')" required autofocus autocomplete="longitude" />
                                <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="radius" :value="__('Radius (km)')" />
                                <x-text-input id="radius" name="radius" type="text" class="mt-1 block w-full" :value="old('radius')" required autofocus autocomplete="radius" />
                                <x-input-error class="mt-2" :messages="$errors->get('radius')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <x-input-label for="machines" :value="__('Select machines')" />
                                <x-select multiple id="machines" name="machines[]" class="mt-1 block w-full" required autofocus autocomplete="machines">
                                    @foreach($machines as $machine)
                                        <option value="{{$machine->id}}" @if(old('machines') and in_array($machine->id, old('machines'))) selected @endif>{{$machine->name}}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('machines')" />
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
