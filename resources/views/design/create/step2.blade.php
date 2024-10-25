<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Design') }}
        </h2>
    </x-slot>

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

                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 40%"> 40%</div>
                    </div>

                    <form method="post" action="{{ route('design.store.step2') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div class="flex flex-row">
                            <div class="w-full m-4 p-4">
                                <img src="{{asset('/images/footprint.jpg')}}" alt="Helper">
                            </div>
                        </div>

                        <h2>
                            Enter footprint shelter's details:
                        </h2>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="width" :value="__('Width')" />
                                <x-text-input id="width" name="width" type="number" step="0.1" class="mt-1 block w-full" :value="$design->width" required autofocus autocomplete="width" />
                                <x-input-error class="mt-2" :messages="$errors->get('width')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="length" :value="__('Length')" />
                                <x-text-input id="length" name="length" type="number" step="0.1" class="mt-1 block w-full" :value="$design->length" required autofocus autocomplete="length" />
                                <x-input-error class="mt-2" :messages="$errors->get('length')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="height" :value="__('Height')" />
                                <x-text-input id="height" name="height" type="number" step="0.1" class="mt-1 block w-full" :value="$design->height" required autofocus autocomplete="height" />
                                <x-input-error class="mt-2" :messages="$errors->get('height')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="slab_thickness" :value="__('Slab thickness')" />
                                <x-text-input id="slab_thickness" name="slab_thickness" type="number" step="0.1" class="mt-1 block w-full" :value="$design->slab_thickness" required autofocus autocomplete="slab_thickness" />
                                <x-input-error class="mt-2" :messages="$errors->get('slab_thickness')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="column_number" :value="__('Column number')" />
                                <x-text-input id="column_number" name="column_number" type="number" step="2" class="mt-1 block w-full" :value="$design->column_number" required autofocus autocomplete="column_number" />
                                <x-input-error class="mt-2" :messages="$errors->get('column_number')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{route('design.create.step1')}}">
                                <x-secondary-button>{{__('Previous')}}</x-secondary-button>
                            </a>

                            <x-primary-button>{{ __('Save and next') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
