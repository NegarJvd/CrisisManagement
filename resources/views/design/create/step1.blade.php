<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Design') }}
        </h2>
    </x-slot>

    <script type="module">
        $(document).ready(function() {

            $('#woods').on('click', function (){
                const id = $('#woods').val()
                $('.details').addClass('hidden')
                const p_id = 'details_'+id
                $('#'+p_id).removeClass('hidden')
            })
        })
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">

                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 20%"> 20%</div>
                    </div>

                    <form method="post" action="{{ route('design.store.step1') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <div class="flex flex-row">
                            <div class="basis-1/4 mr-2">
                                <x-input-label for="woods" :value="__('Select woods')" />
                                <x-select id="woods" name="woods" class="mt-1 block w-full" required autofocus autocomplete="woods">
                                    <option></option>
                                    @foreach(App\Models\Wood::all() as $wood)
                                        <option value="{{$wood->id}}" @if($woods and $wood->id == $woods) selected @endif>{{$wood->name}} ({{$wood->type}})</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('woods')" />
                            </div>

                            <div class="basis-1/4 mr-2">
                                <div id="create_wood" class="flex flex-row justify-start text-center mt-6">
                                    <a class="border border-slate-600 p-1 rounded-lg hover:bg-gray-100" href="{{route('wood-management.create')}}" target=”_blank”>
                                        Create new
                                    </a>
                                </div>
                            </div>

                            <div class="basis-2/4 mr-2">
                                @foreach(App\Models\Wood::all() as $wood)
                                    <p id="details_{{$wood->id}}" class="hidden details">
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
                                    </p>
                                @endforeach
                            </div>
                        </div>


                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save and next') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
