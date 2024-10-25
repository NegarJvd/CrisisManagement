<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Supply Point') }}
        </h2>
    </x-slot>

    <script type="module">
        $(document).ready(function() {
            $('#shipping').on('change', function (){
                if($(this).prop('checked')){
                    $('#radius_div').removeClass('hidden')
                }else{
                    $('#radius_div').addClass('hidden')
                    $('#radius').val(0).change()
                }
            })

            $('#woods').on('click', function (){
                const ids = $('#woods').val()
                $('.details').addClass('hidden')

                for(var i=0; i<ids.length; i++){
                    const p_id = 'details_'+ids[i]
                    $('#'+p_id).removeClass('hidden')
                }
            })
        })
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">
                    <form method="post" action="{{ route('timber-provider.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div class="w-full">
                            <div id="map" style="height: 400px"></div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <h2>
                                    Choose your coordinate on map:
                                </h2>
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="latitude" :value="__('Latitude')" />
                                <x-text-input readonly id="latitude" name="latitude" type="text" class="mt-1 block w-full" :value="old('latitude')" required autofocus autocomplete="latitude" />
                                <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="longitude" :value="__('Longitude')" />
                                <x-text-input readonly id="longitude" name="longitude" type="text" class="mt-1 block w-full" :value="old('longitude')" required autofocus autocomplete="longitude" />
                                <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <div class="flex">
                                    <x-input-label for="shipping" :value="__('Do you have shipping?')" />
                                    <x-text-input id="shipping" type="checkbox" class="mt-1 ml-3 block" autofocus autocomplete="shipping" />
                                    <x-input-error class="mt-2" :messages="$errors->get('shipping')" />
                                </div>
                            </div>

                            <div class="basis-1/3 mr-2 ml-2 hidden" id="radius_div" >
                                <x-input-label for="radius" :value="__('Radius (km)')" />
                                <x-text-input id="radius" name="radius" type="text" class="mt-1 block w-full" :value="old('radius') ?? 0" required autofocus autocomplete="radius" />
                                <x-input-error class="mt-2" :messages="$errors->get('radius')" />
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="woods" :value="__('Select woods')" />
                                <x-select multiple id="woods" name="woods[]" class="mt-1 block w-full" required autofocus autocomplete="woods">
                                    @foreach($woods as $wood)
                                        <option value="{{$wood->id}}" @if(old('woods') and in_array($wood->id, old('woods'))) selected @endif>{{$wood->name}} ({{$wood->type}})</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('woods')" />
                            </div>
                            <div class="basis-2/3 ml-2 h-[350px] overflow-y-auto">
                                @foreach($woods as $wood)
                                    <p id="details_{{$wood->id}}" class="hidden details">
                                        <b>name : {{$wood->name}}</b><br>
                                        bending strength : {{$wood->bending_strength}} <br>
                                        tension parallel : {{$wood->tension_parallel}} | tension perpendicular : {{$wood->tension_perpendicular}} <br>
                                        compression parallel : {{$wood->compression_parallel}} | compression perpendicular : {{$wood->compression_perpendicular}} <br>
                                        shear strength : {{$wood->shear_strength}} <br>
                                        e modulus : {{$wood->e_modulus}} | e modulus 5% : {{$wood->e_modulus_5}} <br>
                                        partial factor : {{$wood->partial_factor}} | density : {{$wood->density}}  <br>
                                        modification factor permanent, medium and instantaneous term : {{$wood->modification_factor_permanent_term}} | {{$wood->modification_factor_medium_term}} | {{$wood->modification_factor_instantaneous_term}}<br>
                                        creep factor : {{$wood->creep_factor}} | creep factor solid timber : {{$wood->creep_factor_solid_timber}} <br>
                                        end distance : {{$wood->dtl_e}} | edge distance : {{$wood->dtl_v}} <br>
                                        vertical edge distance : {{$wood->dtl_g}} | peg spacing distance : {{$wood->dtl_s}}
                                        <br>
                                        <br>
                                    </p>
                                @endforeach
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
