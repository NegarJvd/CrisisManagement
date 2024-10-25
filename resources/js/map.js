import 'leaflet/dist/leaflet.css';
import L from 'leaflet';

const red_pin = L.icon({
    iconUrl: '/icons/red_pin.png',
    iconSize: [32, 32],
});
const blue_pin = L.icon({
    iconUrl: '/icons/blue_pin.png',
    iconSize: [32, 32],
});
const green_pin = L.icon({
    iconUrl: '/icons/green_pin.png',
    iconSize: [32, 32],
});

let map;
let markers = [];
let timber_markers = [];
let cnc_markers = [];

document.addEventListener('DOMContentLoaded', () => {

    let map_div = document.getElementById("map");
    if (map_div)
    {
        let crisis_lat_element = document.getElementById('crisis_lat');
        let crisis_lon_element = document.getElementById('crisis_lon');
        let latitude_element = document.getElementById('latitude');
        let longitude_element = document.getElementById('longitude');
        let radius_element = document.getElementById('radius');

        if (crisis_lat_element && crisis_lon_element)
        {
            //design show page
            let crisis_lat = crisis_lat_element.value;
            let crisis_lon = crisis_lon_element.value;

            let center_lat = crisis_lat ?? 40.784;
            let center_lon = crisis_lon ?? -73.998;

            map = L.map('map').setView([center_lat, center_lon], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            if (crisis_lat && crisis_lon)
            {
                let locations = [
                    { lat: crisis_lat, lng: crisis_lon, name: 'Your Location',  icon:green_pin},
                ];

                //timbers
                let timbers_name_elements = document.getElementsByClassName('timber_name');
                let timbers_lat_elements = document.getElementsByClassName('timber_lat');
                let timbers_lon_elements = document.getElementsByClassName('timber_lon');

                for (let i=0; i<timbers_name_elements.length; i++)
                {
                    locations.push(
                        {lat: timbers_lat_elements[i].value, lng: timbers_lon_elements[i].value, name: 'Timber: ' + timbers_name_elements[i].textContent, icon: blue_pin}
                    );
                }

                //CNC
                let cnc_name_elements = document.getElementsByClassName('cnc_name');
                let cnc_lat_elements = document.getElementsByClassName('cnc_lat');
                let cnc_lon_elements = document.getElementsByClassName('cnc_lon');

                for (let i=0; i<cnc_name_elements.length; i++)
                {
                    locations.push(
                        {lat: cnc_lat_elements[i].value, lng: cnc_lon_elements[i].value, name: 'CNC: ' + cnc_name_elements[i].textContent, icon: red_pin}
                    );
                }

                locations.forEach(location => {
                    L.marker([location.lat, location.lng], {icon: location.icon}).addTo(map)
                        .bindTooltip(location.name)
                        .openTooltip();
                });
            }
        }
        else if(latitude_element && longitude_element && radius_element)
        {
            //timber and CNC page
            let center_lat = latitude_element.value ?? 40.784;
            let center_lon = longitude_element.value ?? -73.998;
            let radius = radius_element.value * 1000 > 0 ? radius_element.value * 1000 : 0; //1000 km

            let markers = [];
            let circles = [];

            map = L.map('map').setView([center_lat, center_lon], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // add a marker at center
            const marker = L.marker([center_lat, center_lon], {icon: blue_pin}).addTo(map);
            const circle = L.circle([center_lat, center_lon], {radius: radius}).addTo(map);

            // Add the new marker to the array
            markers.push(marker);
            circles.push(circle);

            map.on('click', function(e) {
                const { lat, lng } = e.latlng;
                radius = radius_element.value * 1000;

                // Remove existing markers
                markers.forEach(marker => map.removeLayer(marker));
                circles.forEach(circle => map.removeLayer(circle));

                // add a marker at the clicked location
                const marker = L.marker([lat, lng], {icon: blue_pin}).addTo(map);
                const circle = L.circle([lat, lng], {radius: radius}).addTo(map);

                //change input values
                latitude_element.setAttribute('value', lat);
                longitude_element.setAttribute('value', lng);
                center_lat = lat;
                center_lon = lng;

                // Add the new marker to the array
                markers.push(marker);
                circles.push(circle);
            });

            radius_element.onchange = function (){
                circles.forEach(circle => map.removeLayer(circle));

                radius = radius_element.value * 1000;
                const circle = L.circle([center_lat, center_lon], {radius: radius}).addTo(map);
                circles.push(circle);
            };
        }
        else
        {
            //crisis stricken page + design create 60%
            let center_lat = latitude_element.value ?? 40.784;
            let center_lon = longitude_element.value ?? -73.998;

            map = L.map('map').setView([center_lat, center_lon], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // add a marker at center
            const marker = L.marker([center_lat, center_lon], {icon: blue_pin}).addTo(map);

            // Add the new marker to the array
            markers.push(marker);

            map.on('click', function(e) {
                const { lat, lng } = e.latlng;

                // Remove existing markers
                markers.forEach(marker => map.removeLayer(marker));
                timber_markers.forEach(marker => map.removeLayer(marker));
                cnc_markers.forEach(marker => map.removeLayer(marker));

                // add a marker at the clicked location
                const marker = L.marker([lat, lng], {icon: blue_pin}).addTo(map);

                //change input values
                latitude_element.setAttribute('value', lat);
                longitude_element.setAttribute('value', lng);

                // Add the new marker to the array
                markers.push(marker);

                //------------------------------------------------------------------------------------------------------
                const just_for_filtering_shelter_seekers = document.getElementById('timber_provider_table')
                if(just_for_filtering_shelter_seekers){
                    //finding in range providers
                    $.ajax({
                        url: '/shelter_seekers/providers',
                        type: 'POST',
                        async: true,
                        contentType: 'application/json',
                        data: JSON.stringify({
                            "latitude" : lat,
                            "longitude" : lng
                        }),
                        success: function (data, textStatus, jQxhr) {
                            const response = JSON.parse(jQxhr.responseText);

                            let timber_providers = response.timber_providers;
                            let cnc_providers = response.cnc_providers;

                            //timber part
                            let timber_provider_table = $('#timber_provider_table tbody');
                            timber_provider_table.text('')
                            let timber_supply_points_table = $('#timber_supply_points_table tbody');
                            timber_supply_points_table.text('')
                            if (timber_providers.length > 0){
                                for (let t in timber_providers) {
                                    let timber = timber_providers[t]

                                    let timber_provider_row_id = "timber_provider_"+timber.provider.id
                                    let provider_row = '<tr class="border border-slate-600 py-3 cursor-pointer hover:bg-gray-100 timber_provider_row" id="'+ timber_provider_row_id +'">' +
                                        '<td class="border border-slate-600 py-3">'+
                                        timber.provider.id +
                                        '</td><td class="border border-slate-600 py-3">'+
                                        timber.provider.name +
                                        '</td><td class="border border-slate-600 py-3">'+
                                        timber.provider.email +
                                        '</td>' +
                                        '</tr>'

                                    timber_provider_table.append(provider_row)

                                    for (let ts in timber.supply_points) {
                                        let supply_point = timber.supply_points[ts]

                                        let supply_point_row = '<tr class="border border-slate-600 py-3 timber_supply_points hidden '+ timber_provider_row_id +'">' +
                                            '<td class="border border-slate-600 py-3 supply_point_id">'+
                                            supply_point.id +
                                            '</td><td class="border border-slate-600 py-3">'+
                                            supply_point.radius +
                                            '</td><td class="supply_point_lat hidden">'+
                                            supply_point.latitude +
                                            '</td><td class="supply_point_lng hidden">'+
                                            supply_point.longitude +
                                            '</td><td class="py-3 flex flex-row items-center justify-center"><div class="flex items-center justify-center">'+
                                            '<input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded select_timber">' +
                                            '</div></td></tr>'

                                        timber_supply_points_table.append(supply_point_row)
                                    }
                                }
                            }

                            //cnc part
                            let cnc_provider_table = $('#cnc_provider_table tbody');
                            cnc_provider_table.text('')
                            let cnc_supply_points_table = $('#cnc_supply_points_table tbody');
                            cnc_supply_points_table.text('')
                            if (cnc_providers.length > 0){
                                for (let c in cnc_providers) {
                                    let cnc = cnc_providers[c]

                                    let cnc_provider_row_id = "cnc_provider_"+cnc.provider.id
                                    let provider_row = '<tr class="border border-slate-600 py-3 cursor-pointer hover:bg-gray-100 cnc_provider_row" id="'+ cnc_provider_row_id +'">' +
                                        '<td class="border border-slate-600 py-3">'+
                                        cnc.provider.id +
                                        '</td><td class="border border-slate-600 py-3">'+
                                        cnc.provider.name +
                                        '</td><td class="border border-slate-600 py-3">'+
                                        cnc.provider.email +
                                        '</td>' +
                                        '</tr>'

                                    cnc_provider_table.append(provider_row)

                                    for (let cs in cnc.supply_points) {
                                        let supply_point = cnc.supply_points[cs]

                                        let supply_point_row = '<tr class="border border-slate-600 py-3 cnc_supply_points hidden '+ cnc_provider_row_id +'">' +
                                            '<td class="border border-slate-600 py-3 supply_point_id">'+
                                            supply_point.id +
                                            '</td><td class="border border-slate-600 py-3">'+
                                            supply_point.radius +
                                            '</td><td class="supply_point_lat hidden">'+
                                            supply_point.latitude +
                                            '</td><td class="supply_point_lng hidden">'+
                                            supply_point.longitude +
                                            '</td><td class="py-3 flex flex-row items-center justify-center"><div class="flex items-center justify-center">'+
                                            '<input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded select_cnc">' +
                                            '</div></td></tr>'

                                        cnc_supply_points_table.append(supply_point_row)
                                    }
                                }
                            }
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            const response = JSON.parse(jqXhr.responseText);
                            // console.log(response)

                            alert("Error! please try again later.")
                        },
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                }
            });

        }
    }
});

$(document).on('click', '.timber_provider_row', function (){
    $('.timber_supply_points').addClass('hidden')

    let timber_provider_id = $(this)[0].id
    $('.'+ timber_provider_id).removeClass('hidden')

    let ids = $('.'+ timber_provider_id + ' .supply_point_id')
    let lats = $('.'+ timber_provider_id + ' .supply_point_lat')
    let lngs = $('.'+ timber_provider_id + ' .supply_point_lng')

    let locations = [];
    for (var i=0; i<ids.length; i++){
        locations.push({
            lat: $(lats[i]).text(), lng: $(lngs[i]).text(), name: $(ids[i]).text(),  icon:red_pin
        })
    }

    // Remove existing markers
    timber_markers.forEach(marker => map.removeLayer(marker));

    for(var j=0; j<locations.length; j++){
        let m = L.marker([locations[j].lat, locations[j].lng], {icon: locations[j].icon})
            .addTo(map)
            .bindTooltip(locations[j].name)
            .openTooltip();
        timber_markers.push(m);
    }

})

$(document).on('click', '.cnc_provider_row', function (){
    $('.cnc_supply_points').addClass('hidden')

    let cnc_provider_id = $(this)[0].id
    $('.'+ cnc_provider_id).removeClass('hidden')

    let ids = $('.'+ cnc_provider_id + ' .supply_point_id')
    let lats = $('.'+ cnc_provider_id + ' .supply_point_lat')
    let lngs = $('.'+ cnc_provider_id + ' .supply_point_lng')

    let locations = [];
    for (var i=0; i<ids.length; i++){
        locations.push({
            lat: $(lats[i]).text(), lng: $(lngs[i]).text(), name: $(ids[i]).text(),  icon:green_pin
        })
    }

    // Remove existing markers
    cnc_markers.forEach(marker => map.removeLayer(marker));

    for(var j=0; j<locations.length; j++){
        let m = L.marker([locations[j].lat, locations[j].lng], {icon: locations[j].icon})
            .addTo(map)
            .bindTooltip(locations[j].name)
            .openTooltip();
        cnc_markers.push(m);
    }

})
