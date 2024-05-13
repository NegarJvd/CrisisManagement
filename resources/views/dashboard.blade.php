<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <script type="module">
        // $('a').on('click', function (){
        //
        // });
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-row dark:text-gray-100">
                    <a href="{{route('design.index')}}" class="basis-1/4 group block max-w-xs mx-auto rounded-lg p-6 mr-2 ml-2 ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-gray-100 hover:ring-gray-100">
                        <div class="items-center text-center">
                            <img src="{{asset('/icons/designer.png')}}" alt="Designer Dashboard">
                            <h2 class="mt-2 dark:text-gray-100">{{ __('Designer Dashboard') }}</h2>
                        </div>
                    </a>

                    <a href="{{route('timber-supply.index')}}" class="basis-1/4 group block max-w-xs mx-auto rounded-lg p-6 mr-2 ml-2 ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-gray-100 hover:ring-gray-100">
                        <div class="items-center text-center">
                            <img src="{{asset('/icons/timber-supplier.png')}}" alt="Timber Supplier Dashboard">
                            <h2 class="mt-2 dark:text-gray-100">{{ __('Timber Supplier Dashboard') }}</h2>
                        </div>
                    </a>

                    <a href="{{route('cnc-supply.index')}}" class="basis-1/4 group block max-w-xs mx-auto rounded-lg p-6 mr-2 ml-2 ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-gray-100 hover:ring-gray-100">
                        <div class="items-center text-center">
                            <img src="{{asset('/icons/cnc-supplier.png')}}" alt="CNC Supplier Dashboard">
                            <h2 class="mt-2 dark:text-gray-100">{{ __('CNC Supplier Dashboard') }}</h2>
                        </div>
                    </a>

                    <a href="#" class="basis-1/4 group block max-w-xs mx-auto rounded-lg p-6 mr-2 ml-2 ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-gray-100 hover:ring-gray-100">
                        <div class="items-center text-center">
                            <img src="{{asset('/icons/crisis-stricken.png')}}" alt="Crisis-stricken Dashboard">
                            <h2 class="mt-2 dark:text-gray-100">{{ __('Crisis-stricken Dashboard') }}</h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
