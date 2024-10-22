<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Design Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">

                    <div class="flex flex-row">
                        <div class="basis-1/2 mr-2" id="information">
                            {!! $design->information !!}
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
