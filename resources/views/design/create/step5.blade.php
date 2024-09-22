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

                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 100%"> 100%</div>
                    </div>

                    <form method="post" action="{{ route('design.store.step5') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf

                        <h2>
                            Enter joint type:
                        </h2>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="joint_1" :value="__('Joint 1')" />
                                <x-select id="joint_1" name="joint1" class="mt-1 block w-full" required autofocus autocomplete="joint1">
                                    @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                        <option value="{{$joint_type}}" @if($design->joint1 == $joint_type) selected @endif>{{$joint_type}}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('joint1')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="joint_2" :value="__('Joint 2')" />
                                <x-select id="joint_2" name="joint2" class="mt-1 block w-full" required autofocus autocomplete="joint2">
                                    @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                        <option value="{{$joint_type}}" @if($design->joint2 == $joint_type) selected @endif>{{$joint_type}}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('joint2')" />
                            </div>

                            <div class="basis-1/3 mr-2 ml-2">
                                <x-input-label for="joint_3" :value="__('Joint 3')" />
                                <x-select id="joint_3" name="joint3" class="mt-1 block w-full" required autofocus autocomplete="joint3">
                                    @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                        <option value="{{$joint_type}}" @if($design->joint3 == $joint_type) selected @endif>{{$joint_type}}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('joint3')" />
                            </div>

                            <div class="basis-1/3 ml-2">
                                <x-input-label for="joint_4" :value="__('Joint 4')" />
                                <x-select id="joint_4" name="joint4" class="mt-1 block w-full" required autofocus autocomplete="joint4">
                                    @foreach(\App\Enums\JointTypeEnum::values() as $joint_type)
                                        <option value="{{$joint_type}}" @if($design->joint4 == $joint_type) selected @endif>{{$joint_type}}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('joint4')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{route('design.create.step4')}}">
                                <x-secondary-button>{{__('Previous')}}</x-secondary-button>
                            </a>

                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
