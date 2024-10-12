import 'leaflet/dist/leaflet.css';
import L from 'leaflet';

document.addEventListener('DOMContentLoaded', () => {

    let map_div = document.getElementById("map");
    if (map_div)
    {
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

            const map = L.map('map').setView([center_lat, center_lon], 5);

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

            const map = L.map('map').setView([center_lat, center_lon], 5);

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
            //crisis stricken page
            let center_lat = latitude_element.value ?? 40.784;
            let center_lon = longitude_element.value ?? -73.998;

            let markers = [];

            const map = L.map('map').setView([center_lat, center_lon], 5);

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

                // add a marker at the clicked location
                const marker = L.marker([lat, lng], {icon: blue_pin}).addTo(map);

                //change input values
                latitude_element.setAttribute('value', lat);
                longitude_element.setAttribute('value', lng);

                // Add the new marker to the array
                markers.push(marker);


                $('#load_calculator_result').text(
                    'Wind pressure results for direct wind:\n' +
                    'We for area A: -0.50 kN/mˆ2\n' +
                    'We for area B: -0.33 kN/mˆ2\n' +
                    'We for area C: -0.21 kN/mˆ2\n' +
                    'We for area D: 0.33 kN/mˆ2\n' +
                    'We for area E: -0.21 kN/mˆ2\n' +
                    '\n' +
                    '\n' +
                    'Wind pressure results for side wind:\n' +
                    'We for area A: -0.50 kN/mˆ2\n' +
                    'We for area B: -0.33 kN/mˆ2\n' +
                    'We for area C: -0.21 kN/mˆ2\n' +
                    'We for area D: 0.33 kN/mˆ2\n' +
                    'We for area E: -0.21 kN/mˆ2\n' +
                    '\n' +
                    '\n' +
                    'Wind load on the beam (wk): 0.66 kN/m\n' +
                    'Maximum load for ULS Category 1 (Permanent): 2.98 kN/m\n' +
                    'Maximum load for ULS Category 2 (Medium-term): 3.82 kN/m\n' +
                    'Maximum load for ULS Category 3 (Instantaneous): 4.82 kN/m\n' +
                    'Maximum load for SLS: 3.43 kN/m\n' +
                    'Leading varible action: 0.80 kN/m\n' +
                    'accompanying variable action: 0.66 kN/m\n' +
                    'psi_lead: 0.20\n' +
                    'psi_acmp: 0.00'
                )
            });

        }
    }
});
