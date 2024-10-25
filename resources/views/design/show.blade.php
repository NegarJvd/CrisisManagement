<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Design Detail') }}
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

                    <div class="flex flex-row">
                        <div class="basis-1/2 mr-2" id="information">
                            {!! $design->information !!}

                            <br><br>

                            <b>Material details:</b><br>
                            <p>
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
                        </div>
                        <div class="basis-1/2 ml-2">
                            <img src="{{asset('/final.jpg')}}">
                        </div>

                    </div>

                    <div class="mt-6">
                        <a href="{{route('design.index')}}">
                            <x-primary-button>{{ __('Back to Design List') }}</x-primary-button>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
