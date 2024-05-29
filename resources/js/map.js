import 'leaflet/dist/leaflet.css';
import L from 'leaflet';

document.addEventListener('DOMContentLoaded', () => {

    let map_div = document.getElementById("map");
    if (map_div)
    {
        let crisis_lat_element = document.getElementById('crisis_lat');
        let crisis_lon_element = document.getElementById('crisis_lon');

        if (crisis_lat_element && crisis_lon_element)
        {
            //design show page
            let crisis_lat = crisis_lat_element.value;
            let crisis_lon = crisis_lon_element.value;

            let center_lat = crisis_lat ?? 51.505;
            let center_lon = crisis_lon ?? -0.09;

            const map = L.map('map').setView([center_lat, center_lon], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            if (crisis_lat && crisis_lon)
            {
                let locations = [
                    { lat: crisis_lat, lng: crisis_lon, name: 'Your Location' },
                ];

                //timbers
                let timbers_name_elements = document.getElementsByClassName('timber_name');
                let timbers_lat_elements = document.getElementsByClassName('timber_lat');
                let timbers_lon_elements = document.getElementsByClassName('timber_lon');

                for (let i=0; i<timbers_name_elements.length; i++)
                {
                    locations.push(
                        {lat: timbers_lat_elements[i].value, lng: timbers_lon_elements[i].value, name: 'Timber: ' + timbers_name_elements[i].textContent}
                    );
                }

                //CNC
                let cnc_name_elements = document.getElementsByClassName('cnc_name');
                let cnc_lat_elements = document.getElementsByClassName('cnc_lat');
                let cnc_lon_elements = document.getElementsByClassName('cnc_lon');

                for (let i=0; i<cnc_name_elements.length; i++)
                {
                    locations.push(
                        {lat: cnc_lat_elements[i].value, lng: cnc_lon_elements[i].value, name: 'CNC: ' + cnc_name_elements[i].textContent}
                    );
                }

                locations.forEach(location => {
                    L.marker([location.lat, location.lng]).addTo(map)
                        .bindPopup(location.name)
                        .openPopup();
                });
            }
        }
        else
        {
            //timber and CNC page
            let latitude_element = document.getElementById('latitude');
            let longitude_element = document.getElementById('longitude');

            let center_lat = latitude_element.value ?? 51.505;
            let center_lon = longitude_element.value ?? -0.09;

            let markers = [];

            const map = L.map('map').setView([center_lat, center_lon], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // add a marker at center
            const marker = L.marker([center_lat, center_lon]).addTo(map);

            // Add the new marker to the array
            markers.push(marker);

            map.on('click', function(e) {
                const { lat, lng } = e.latlng;

                // Remove existing markers
                markers.forEach(marker => map.removeLayer(marker));

                // add a marker at the clicked location
                const marker = L.marker([lat, lng]).addTo(map);

                //change input values
                latitude_element.setAttribute('value', lat);
                longitude_element.setAttribute('value', lng);

                // Add the new marker to the array
                markers.push(marker);
            });
        }
    }
});
