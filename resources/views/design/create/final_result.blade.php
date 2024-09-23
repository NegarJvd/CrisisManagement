<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Design') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">

                    <div class="mt-6 space-y-6">
                        <div class="flex flex-row">
                            <div class="basis-1/2 mr-2">
                                <h2 class="font-bold">
                                    Structural details and performance
                                </h2>

                                <p>
                                    Weight: 13.17 kg, width: 85 mm, height: 127 mm, Beam Length: 2.00 m, Bending Utilisation(beam): 35.78%, Bending Status (beam): Acceptable, Shear Utilisation(beam) : 22.97%, Shear Status (beam): Acceptable, SLS Utilisation(beam): 99.61%, SLS Status(beam): Acceptable, b.clm: 85 mm, w.clm: 127.00 mm, w.tb: 127 mm, t.t: 190.50 mm, Compression Utilisation(column): 3.79%, Compression status(column): Acceptable, Buckling Utilisation in plane(column): 2.48%, Buckling status in plane(column): Acceptable,Buckling Utilisation out of plane (column): 4.72%, Buckling status out of plane(column): Acceptable, Final Utilisation: 99.61%, Final utilisation status: Acceptable
                                </p>

                                <h2 class="font-bold">
                                    Joint details
                                </h2>

                                <p>
                                    D (mm): 26.416, lim_e (mm): 56.85, lim_s (mm): 71.07, lim_v (mm): 42.64, lim_g (mm): 42.64, Capacity (kN): 11.47, Status: Acceptable
                                </p>
                            </div>
                            <div class="basis-1/2 ml-2">
                                <img src="{{asset('/final.jpg')}}">
                            </div>

                        </div>
                    </div>


                        <a href="{{route('design.index')}}">
                            <x-primary-button>{{ __('Back to Design List') }}</x-primary-button>
                        </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
