<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('CNC Supply Orders') }}
            </h2>
        </div>
    </x-slot>

    <script type="module">
        $(document).ready(function() {
            $('.get_gcode').on('click', function (){
                let div = $(this).parent();
                let column_h = div.find('.design_column_h').val()
                let tie_beam_h = div.find('.design_top_plate_h').val()
                let tie_beam_w = div.find('.design_top_plate_w').val()

                const url = "{!! env('FLASK_URL') !!}" + '/generate_g_code';

                $.ajax({
                    url: url,
                    type: 'POST',
                    async: true,
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "column_h": parseFloat(column_h),
                        "tie_beam_h": parseFloat(tie_beam_h),
                        "tie_beam_w": parseFloat(tie_beam_w),
                    }),
                    success: function (data, textStatus, jQxhr) {
                        const response = JSON.parse(jQxhr.responseText);
                        // console.log(response)
                        $('#g_code_text').text(response).change();
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        const response = JSON.parse(jqXhr.responseText);
                        alert(response)
                    },
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            })

            $('#copy_gcode').on('click', function (){
                const text = $('#g_code_text').text();

                // Use the Clipboard API to copy text
                navigator.clipboard.writeText(text)
                    .then(() => {
                        alert("Text copied to clipboard!");
                    })
                    .catch(err => {
                        console.error("Error copying text: ", err);
                    });
            })
        })
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto dark:text-gray-100">
                    <table class="table-auto w-full border-collapse border border-slate-500 text-center">
                        <thead>
                        <tr class="border border-slate-600 bg-gray-100 py-3">
                            <th class="border border-slate-600 py-3">Id</th>
                            <th class="border border-slate-600 py-3">Customer</th>
                            <th class="border border-slate-600 py-3">Designer</th>
                            <th class="border border-slate-600 py-3">Woods</th>
                            <th class="border border-slate-600 py-3">Order Date</th>
                            <th class="border border-slate-600 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($orders as $order)
                            <tr class="border border-slate-600 py-3">
                                <td class="border border-slate-600 py-3">{{$order->id}}</td>
                                <td class="border border-slate-600 py-3">{{$order->user->email}}</td>
                                <td class="border border-slate-600 py-3">{{$order->design->user->name}}</td>
                                <td class="border border-slate-600 py-3">
                                    {{implode(' , ', $order->design->woods()->pluck('name')->toArray())}}
                                </td>
                                <td class="border border-slate-600 py-3">
                                    {{$order->created_at}}
                                </td>
                                <td class="py-3 flex flex-row items-center justify-center">
                                    <div class="basis-1/2 flex items-center justify-center">
                                        <a href="{{route('design.show', $order->design->id)}}" title="show details">
                                            <img class="w-4 hover:bg-gray-300" src="{{asset('/icons/show.png')}}" alt="show">
                                        </a>
                                    </div>
                                    <div class="basis-1/2 flex items-center justify-center">
                                        <x-text-input class="design_column_h" value="{{$order->design->column_h}}" hidden="hidden"/>
                                        <x-text-input class="design_top_plate_w" value="{{$order->design->top_plate_w}}" hidden="hidden"/>
                                        <x-text-input class="design_top_plate_h" value="{{$order->design->top_plate_h}}" hidden="hidden"/>

                                        <x-button class="get_gcode"
                                            x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'generate-gcode')"
                                        >
                                            <img class="w-4 hover:bg-gray-300" src="{{asset('/icons/gcode.png')}}" alt="get gcode" title="get gcode">
                                        </x-button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{$orders->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-modal name="generate-gcode" focusable>
    <div class="flex flex-col items-center justify-center p-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 text-center mb-2">
            {{ __('G code generation') }}
        </h2>

        <div class="flex items-center space-x-3 mt-2 mb-2">
            <x-primary-button type="button" id="copy_gcode">
                {{ __('Copy Code') }}
            </x-primary-button>
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
        </div>

        <div class="mt-2 flex flex-col items-center">
            <p id="g_code_text" class="text-center mb-6"></p>
        </div>
    </div>
</x-modal>

