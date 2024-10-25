<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Lets find shelter for you!') }}
            </h2>
        </div>
    </x-slot>

    <script type="module">
        let design_table_page = 1
        let design_table_last_page = 1

        function get_filtered_designs(page) {
            $.ajax({
                url: '/design',
                type: 'GET',
                async: true,
                contentType: 'application/json',
                data: {
                    "width_min": $("#width_min").val(),
                    "width_max": $("#width_max").val(),
                    "length_min": $("#length_min").val(),
                    "length_max": $("#length_max").val(),
                    "height_min": $("#height_min").val(),
                    "height_max": $("#height_max").val(),
                    "page": page
                },
                success: function (data, textStatus, jQxhr) {
                    const response = JSON.parse(jQxhr.responseText);
                    // console.log(response)

                    design_table_last_page = response.meta.last_page
                    design_table_page = page
                    if (design_table_last_page > design_table_page)
                        $('#load_more_design').removeClass('hidden')
                    else
                        $('#load_more_design').addClass('hidden')

                    if (response.data.length > 0) {
                        var design_list = response.data

                        //then send the results for load verify
                        const url = "{!! env('FLASK_URL') !!}" + '/design_verify';
                        $.ajax({
                            url: url,
                            type: 'POST',
                            async: true,
                            contentType: 'application/json',
                            data: JSON.stringify({
                                "designs": design_list
                            }),
                            success: function (data, textStatus, jQxhr) {
                                const response2 = JSON.parse(jQxhr.responseText);
                                // console.log(response2)

                                let filtered_designs = []
                                if (response2.acceptable_designs.length > 0) {
                                    filtered_designs.push(...response2.acceptable_designs)
                                }

                                //get the acceptable results to add the table
                                let new_row
                                for (var i = 0; i < filtered_designs.length; i++) {
                                    new_row = '<tr class="border border-slate-600 py-3">' +
                                        '<td class="border border-slate-600 py-3 design_id">' + filtered_designs[i].id + '</td>' +
                                        '<td class="border border-slate-600 py-3">' + filtered_designs[i].user.name + '</td>' +
                                        '<td class="border border-slate-600 py-3">' + filtered_designs[i].material.name + '</td>' +
                                        '<td class="border border-slate-600 py-3">' +
                                        'width: ' + filtered_designs[i].footprint.width + ', length: ' + filtered_designs[i].footprint.length + ', height: ' + filtered_designs[i].footprint.height +
                                        ', slab_thickness:  ' + filtered_designs[i].footprint.slab_thickness + ', column_number: ' + filtered_designs[i].footprint.column_number + '' +
                                        '</td>' +
                                        '<td class="py-3 flex flex-row items-center justify-center">' +
                                        '<div class="basis-1/2 flex items-center justify-center">' +
                                        '<a href="/design/' + filtered_designs[i].id + '" target="_blank" title="show details"> <img class="w-4 hover:bg-gray-300" src="/icons/show.png" alt="show"></a>' +
                                        '</div>' +
                                        '<div class="basis-1/2 flex items-center justify-center">' +
                                        '<input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded select_design">' +
                                        '</div>' +
                                        '</td>' +
                                        '</tr>'

                                    $('#designs_table tbody').append(new_row)
                                }
                            },
                            error: function (jqXhr, textStatus, errorThrown) {
                                // const response = JSON.parse(jqXhr.responseText);
                                alert('Please inter valid data for range of footprints!')
                            },
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    const response = JSON.parse(jqXhr.responseText);

                    if (jqXhr.status === 422) {
                        alert(response.message)
                    } else {
                        alert("Error! please try again later.")
                    }
                },
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        $(document).ready(function () {
            $('#search_for_designs').on('click', function () {
                //first send to designs api for check the footprint
                design_table_page = 1
                design_table_last_page = 1
                $('#designs_table tbody').html('')

                get_filtered_designs(design_table_page)
            })

            $('#load_more_design').on('click', function () {
                design_table_page += 1
                get_filtered_designs(design_table_page)
            });

            $(document).on('click', '.select_design', function () {
                // Uncheck all other checkboxes
                $('.select_design').not(this).prop('checked', false);

                let tr = $(this).parent().parent().parent()
                let selected_design_id = tr.find('.design_id').text()
                $('#selected_design_id').val(selected_design_id).change()
            })

            $(document).on('click', '.select_timber', function () {
                // Uncheck all other checkboxes
                $('.select_timber').not(this).prop('checked', false);

                let tr = $(this).parent().parent().parent()
                let selected_supply_id = tr.find('.supply_point_id').text()
                $('#selected_timber_id').val(selected_supply_id).change()
            })

            $(document).on('click', '.select_cnc', function () {
                // Uncheck all other checkboxes
                $('.select_cnc').not(this).prop('checked', false);

                let tr = $(this).parent().parent().parent()
                let selected_supply_id = tr.find('.supply_point_id').text()
                $('#selected_cnc_id').val(selected_supply_id).change()
            })
        })
    </script>

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
                    <div class="mt-4 mb-4">
                        <h2 class="mb-2">Inter footprints range:</h2>

                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="width_min" :value="__('Width min')"/>
                                <x-text-input id="width_min" name="width_min" type="number" step="0.01"
                                              class="mt-1 block w-full"
                                              min="0" :value="0" required autofocus autocomplete="width_min"/>
                                <x-input-error class="mt-2" :messages="$errors->get('width_min')"/>
                            </div>

                            <div class="basis-1/3 mr-2">
                                <x-input-label for="length_min" :value="__('Length min')"/>
                                <x-text-input id="length_min" name="length_min" type="number" step="0.01"
                                              class="mt-1 block w-full"
                                              min="0" :value="0" required autofocus autocomplete="length_min"/>
                                <x-input-error class="mt-2" :messages="$errors->get('length_min')"/>
                            </div>

                            <div class="basis-1/3 mr-2">
                                <x-input-label for="height_min" :value="__('Height min')"/>
                                <x-text-input id="height_min" name="height_min" type="number" step="0.01"
                                              class="mt-1 block w-full"
                                              min="0" :value="0" required autofocus autocomplete="height_min"/>
                                <x-input-error class="mt-2" :messages="$errors->get('height_min')"/>
                            </div>
                        </div>
                        <div class="flex flex-row">
                            <div class="basis-1/3 mr-2">
                                <x-input-label for="width_max" :value="__('Width max')"/>
                                <x-text-input id="width_max" name="width_max" type="number" step="0.01"
                                              class="mt-1 block w-full"
                                              min="0" :value="0" required autofocus autocomplete="width_max"/>
                                <x-input-error class="mt-2" :messages="$errors->get('width_max')"/>
                            </div>

                            <div class="basis-1/3 mr-2">
                                <x-input-label for="length_max" :value="__('Length max')"/>
                                <x-text-input id="length_max" name="length_max" type="number" step="0.01"
                                              class="mt-1 block w-full"
                                              min="0" :value="0" required autofocus autocomplete="length_max"/>
                                <x-input-error class="mt-2" :messages="$errors->get('length_max')"/>
                            </div>

                            <div class="basis-1/3 mr-2">
                                <x-input-label for="height_max" :value="__('Height max')"/>
                                <x-text-input id="height_max" name="height_max" type="number" step="0.01"
                                              class="mt-1 block w-full"
                                              min="0" :value="0" required autofocus autocomplete="height_max"/>
                                <x-input-error class="mt-2" :messages="$errors->get('height_max')"/>
                            </div>
                        </div>

                    </div>

                    <div class="w-full mb-2">
                        <div id="map" style="height: 400px"></div>
                    </div>

                    <div class="flex flex-row mt-4 mb-4">

                        <div class="basis-1/4 mr-2 flex items-center">
                            <span>
                                Choose your location:
                            </span>
                        </div>

                        <div class="basis-1/4 mr-2">
                            <x-input-label for="latitude" :value="__('Latitude')"/>
                            <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full"
                                          :value="$latitude ?? null" required autofocus autocomplete="latitude"/>
                            <x-input-error class="mt-2" :messages="$errors->get('latitude')"/>
                        </div>

                        <div class="basis-1/4 mr-2">
                            <x-input-label for="longitude" :value="__('Longitude')"/>
                            <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full"
                                          :value="$longitude ?? null" required autofocus autocomplete="longitude"/>
                            <x-input-error class="mt-2" :messages="$errors->get('longitude')"/>
                        </div>

                        <div class="basis-1/4 flex items-end mb-1">
                            <x-primary-button id="search_for_designs">{{ __('Search') }}</x-primary-button>
                        </div>
                    </div>

                    <hr>

                    <div class="flex flex-col mt-4 mb-4">
                        <h2 class="mb-2">Acceptable designs:
                            <span id="load_more_design" class="text-blue-500 hover:underline cursor-pointer hidden">load more</span>
                        </h2>
                        <x-input-error class="mt-2" :messages="$errors->get('design_id')" />

                        <table class="table-auto w-full border-collapse border border-slate-500 text-center"
                               id="designs_table">
                            <thead>
                            <tr class="border border-slate-600 bg-gray-100 py-3">
                                <th class="border border-slate-600 py-3">Id</th>
                                <th class="border border-slate-600 py-3">Designer</th>
                                <th class="border border-slate-600 py-3">Woods</th>
                                <th class="border border-slate-600 py-3">Footprint</th>
                                <th class="border border-slate-600 py-3">Actions</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <hr>

                    <div class="flex flex-row mt-4 mb-4" id="timber_providers_div">
                        <div class="basis-1/2 mr-2">
                            <h2 class="mb-2">In range timber providers</h2>
                            <table class="table-auto w-full border-collapse border border-slate-500 text-center"
                                   id="timber_provider_table">
                                <thead>
                                <tr class="border border-slate-600 bg-gray-100 py-3">
                                    <th class="border border-slate-600 py-3">Id</th>
                                    <th class="border border-slate-600 py-3">Name</th>
                                    <th class="border border-slate-600 py-3">Email</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="basis-1/2 ml-2">
                            <h2 class="mb-2">In range supply points</h2>
                            <x-input-error class="mt-2" :messages="$errors->get('timber_id')" />
                            <table class="table-auto w-full border-collapse border border-slate-500 text-center"
                                   id="timber_supply_points_table">
                                <thead>
                                <tr class="border border-slate-600 bg-gray-100 py-3">
                                    <th class="border border-slate-600 py-3">Id</th>
                                    <th class="border border-slate-600 py-3">Range (Km)</th>
                                    <th class="border border-slate-600 py-3">Order</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>

                    <hr>

                    <div class="flex flex-row mt-4 mb-4" id="cnc_providers_div">
                        <div class="basis-1/2 mr-2">
                            <h2 class="mb-2">In range cnc providers</h2>
                            <table class="table-auto w-full border-collapse border border-slate-500 text-center"
                                   id="cnc_provider_table">
                                <thead>
                                <tr class="border border-slate-600 bg-gray-100 py-3">
                                    <th class="border border-slate-600 py-3">Id</th>
                                    <th class="border border-slate-600 py-3">Name</th>
                                    <th class="border border-slate-600 py-3">Email</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="basis-1/2 ml-2">
                            <h2 class="mb-2">In range cnc points</h2>
                            <x-input-error class="mt-2" :messages="$errors->get('cnc_id')" />
                            <table class="table-auto w-full border-collapse border border-slate-500 text-center"
                                   id="cnc_supply_points_table">
                                <thead>
                                <tr class="border border-slate-600 bg-gray-100 py-3">
                                    <th class="border border-slate-600 py-3">Id</th>
                                    <th class="border border-slate-600 py-3">Range (Km)</th>
                                    <th class="border border-slate-600 py-3">Order</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>

                    <form method="post" action="{{ route('order.store') }}" class="flex flex-row mt-6 space-y-6">
                        @csrf
                        <x-text-input id="selected_design_id" name="design_id" hidden="hidden"/>
                        <x-text-input id="selected_timber_id" name="timber_id" hidden="hidden"/>
                        <x-text-input id="selected_cnc_id" name="cnc_id" hidden="hidden"/>

                        <div class="w-full mb-1 flex justify-center items-center">
                            <x-primary-button>{{ __('Submit Order') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
