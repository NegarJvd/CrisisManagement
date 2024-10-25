<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Design') }}
        </h2>
    </x-slot>

    {{--    <script type="module">--}}
    {{--        $(document).ready(function() {--}}
    {{--            $('#woods').select2({--}}
    {{--                placeholder: 'Select options',--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}

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
                    <form method="post" action="{{ isset($fork) ? route('design.store') : route('design.update', $design->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        @isset($fork)
                            <x-text-input id="fork_id" name="fork_id" type="hidden" class="mt-1 block w-full" :value="$design->id" required autofocus autocomplete="fork_id" />
                        @else
                        @method('put')
                        @endisset

                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <x-input-label for="file" :value="__('File of design')" />

                                @isset($fork)
                                    <div class="mt-1 w-full p-1.5 flex flex-row justify-start items-center">
                                        <div class="mr-3 basis-1/6">
                                            <a href="{{route('design.download_file', $design->id)}}" title="download" download=>
                                                <img class="w-8 hover:bg-gray-300" src="{{asset('/icons/file.png')}}" alt="download">
                                            </a>
                                        </div>

                                        <div class="basis-5/6">
                                            <x-text-input id="file" name="file" type="file" class="mt-1 block w-full p-1.5" :value="old('file')" required autofocus />
                                        </div>
                                    </div>

                                @else
                                    @if($design->file_path)
                                        <div class="mt-1 w-full p-1.5 flex flex-row justify-start items-center">
                                            <div class="mr-3">
                                                <a href="{{route('design.download_file', $design->id)}}" title="download" download=>
                                                    <img class="w-8 hover:bg-gray-300" src="{{asset('/icons/file.png')}}" alt="download">
                                                </a>
                                            </div>

                                            <div class="">
                                                <a href="{{route('design.delete_file', $design->id)}}" title="delete">
                                                    <img class="w-8 hover:bg-gray-300" src="{{asset('/icons/delete.png')}}" alt="delete">
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <x-text-input id="file" name="file" type="file" class="mt-1 block w-full p-1.5" :value="old('file')" required autofocus />
                                    @endif
                                @endisset

                                <x-input-error class="mt-2" :messages="$errors->get('file')" />
                            </div>

                            <div class="basis-1/2 ml-2">
                                <x-input-label for="number_of_households" :value="__('Number of households')" />
                                <x-text-input id="number_of_households" name="number_of_households" type="number" class="mt-1 block w-full" :value="old('number_of_households', $design->number_of_households)" required autofocus autocomplete="number_of_households" />
                                <x-input-error class="mt-2" :messages="$errors->get('number_of_households')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <x-input-label for="woods" :value="__('Select woods')" />
                                <x-select multiple id="woods" name="woods[]" class="mt-1 block w-full" required autofocus autocomplete="woods">
                                    @foreach($woods as $wood)
                                        <option value="{{$wood->id}}" @if(in_array($wood->id, old('woods', $design->woods()->pluck('id')->toArray()))) selected @endif>{{$wood->name}} ({{$wood->type}})</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('woods')" />
                            </div>

                            <div class="basis-1/2 ml-2">
                                <x-input-label for="machines" :value="__('Select machines')" />
                                <x-select multiple id="machines" name="machines[]" class="mt-1 block w-full" required autofocus autocomplete="machines">
                                    @foreach($machines as $machine)
                                        <option value="{{$machine->id}}" @if(in_array($machine->id, old('machines', $design->machines()->pluck('id')->toArray()))) selected @endif>{{$machine->name}}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('machines')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="snow_load" :value="__('Snow load')" />
                                <x-text-input id="snow_load" name="snow_load" type="text" class="mt-1 block w-full" :value="old('snow_load', $design->snow_load)" required autofocus autocomplete="snow_load" />
                                <x-input-error class="mt-2" :messages="$errors->get('snow_load')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="wind_load" :value="__('Wind load')" />
                                <x-text-input id="wind_load" name="wind_load" type="text" class="mt-1 block w-full" :value="old('wind_load', $design->wind_load)" required autofocus autocomplete="wind_load" />
                                <x-input-error class="mt-2" :messages="$errors->get('wind_load')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="earthquake_load" :value="__('Earthquake load')" />
                                <x-text-input id="earthquake_load" name="earthquake_load" type="text" class="mt-1 block w-full" :value="old('earthquake_load', $design->earthquake_load)" required autofocus autocomplete="earthquake_load" />
                                <x-input-error class="mt-2" :messages="$errors->get('earthquake_load')" />
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
