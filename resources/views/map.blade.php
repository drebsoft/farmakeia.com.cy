<x-guest-layout>
    @push('header')
        <link rel="stylesheet" href="{{ mix('css/map.css') }}">
    @endpush

    <x-slot name="headerSlot">
        <title>Χάρτης φαρμακείων της Κύπρου</title>
    </x-slot>

    @if(!empty($maps_api_key))
        <x-slot name="scriptloads">
            <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
            <script
                src="https://maps.googleapis.com/maps/api/js?key={{ $maps_api_key }}&callback=initMap&libraries=&v=weekly"
                defer
            ></script>
            <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>
        </x-slot>
    @endif

    <div id="map" style="height: 75vh"></div>

    @if(!empty($maps_api_key))
        <x-slot name="scripts">
            <script>
                let map;
                let allPharmaciesCluster = null;
                let availablePharmaciesCluster = null;
                let rapidTestCluster = null;
                let defaultTab = '{{ $defaultTab }}';

                const pharmacies = @json((!empty($pharmacies) && $pharmacies->count() > 0) ? $pharmacies : []);
                let pharmacyMarkers = [];
                function ShowPharmaciesControl(controlDiv, setActive) {
                    // Set CSS for the control interior.
                    const controlText = document.createElement("div");
                    controlText.className = setActive ? "custom-default-map-button custom-active-map-button" : "custom-default-map-button";
                    controlText.id = "custom-map-button-for-all";
                    controlText.innerHTML = "Όλα";
                    controlText.title = "Πατήστε για προβολή όλων των φαρμακείων";
                    controlDiv.appendChild(controlText);
                    // Setup the click event listeners: simply set the map to Chicago.
                    controlText.addEventListener("click", () => {
                        updateClusterVisibility('all');
                        for (let i = 0; i < pharmacyMarkers.length; i++) {
                            pharmacyMarkers[i].setVisible(true);
                            document.getElementById('custom-map-button-for-all').className = "custom-default-map-button custom-active-map-button"
                        }
                        for (let i = 0; i < availableMarkers.length; i++) {
                            availableMarkers[i].setVisible(false);
                            document.getElementById('custom-map-button-for-available').className = "custom-default-map-button"
                        }
                        for (let i = 0; i < rapidTestMarkers.length; i++) {
                            rapidTestMarkers[i].setVisible(false);
                            document.getElementById('custom-map-button-for-rapid').className = "custom-default-map-button"
                        }
                    });
                }

                const availables = @json((!empty($availables) && $availables->count() > 0) ? $availables : []);
                let availableMarkers = [];
                function ShowAvailablesControl(controlDiv, setActive) {
                    // Set CSS for the control interior.
                    const controlText = document.createElement("div");
                    controlText.className = setActive ? "custom-default-map-button custom-active-map-button" : "custom-default-map-button";
                    controlText.id = "custom-map-button-for-available";
                    controlText.innerHTML = "Εφημερεύοντα";
                    controlText.title = "Πατήστε για προβολή των εφημερεύοντων φαρμακείων";
                    controlDiv.appendChild(controlText);
                    // Setup the click event listeners: simply set the map to Chicago.
                    controlText.addEventListener("click", () => {
                        updateClusterVisibility('availables');
                        for (let i = 0; i < pharmacyMarkers.length; i++) {
                            pharmacyMarkers[i].setVisible(false);
                            document.getElementById('custom-map-button-for-all').className = "custom-default-map-button"
                        }
                        for (let i = 0; i < availableMarkers.length; i++) {
                            availableMarkers[i].setVisible(true);
                            document.getElementById('custom-map-button-for-available').className = "custom-default-map-button custom-active-map-button"
                        }
                        for (let i = 0; i < rapidTestMarkers.length; i++) {
                            rapidTestMarkers[i].setVisible(false);
                            document.getElementById('custom-map-button-for-rapid').className = "custom-default-map-button"
                        }
                    });
                }

                function updateClusterVisibility(type) {

                    switch (type){
                        case 'all':
                            allPharmaciesCluster.setMap(map)
                            availablePharmaciesCluster.setMap(null)
                            rapidTestCluster.setMap(null)
                            break;

                        case 'availables':
                            allPharmaciesCluster.setMap(null)
                            availablePharmaciesCluster.setMap(map)
                            rapidTestCluster.setMap(null)
                            break;

                        case 'rapid':
                            allPharmaciesCluster.setMap(null)
                            availablePharmaciesCluster.setMap(null)
                            rapidTestCluster.setMap(map)
                            break;

                    }
                }

                const withRapidTests = @json((!empty($withRapidTests) && $withRapidTests->count() > 0) ? $withRapidTests : []);
                let rapidTestMarkers = [];
                function ShowRapidTestsControl(controlDiv, setActive) {
                    // Set CSS for the control interior.
                    const controlText = document.createElement("div");
                    controlText.className = setActive ? "custom-default-map-button custom-active-map-button" : "custom-default-map-button";
                    controlText.id = "custom-map-button-for-rapid";
                    controlText.innerHTML = "Rapid Tests";
                    controlText.title = "Πατήστε για προβολή των φαρμακείων που διενεργούν rapid tests";
                    controlDiv.appendChild(controlText);
                    // Setup the click event listeners: simply set the map to Chicago.
                    controlText.addEventListener("click", () => {
                        updateClusterVisibility('rapid');
                        for (let i = 0; i < pharmacyMarkers.length; i++) {
                            pharmacyMarkers[i].setVisible(false);
                            document.getElementById('custom-map-button-for-all').className = "custom-default-map-button"
                        }
                        for (let i = 0; i < availableMarkers.length; i++) {
                            availableMarkers[i].setVisible(false);
                            document.getElementById('custom-map-button-for-available').className = "custom-default-map-button"
                        }
                        for (let i = 0; i < rapidTestMarkers.length; i++) {
                            rapidTestMarkers[i].setVisible(true);
                            document.getElementById('custom-map-button-for-rapid').className = "custom-default-map-button custom-active-map-button"
                        }
                    });
                }

                function initMap() {
                    map = new google.maps.Map(document.getElementById("map"), {
                        center: {lat: 35.121, lng: 33.406},
                        zoom: 9,
                    });

                    const infoWindow = new google.maps.InfoWindow();

                    // Set CSS for the control border.
                    const centerControlDiv = document.createElement("div");
                    centerControlDiv.style.margin = "10px";
                    centerControlDiv.style.zIndex = "0";
                    centerControlDiv.style.cursor = "pointer";

                    for (let i = 0; i < pharmacies.length; i++) {
                        const latLng = new google.maps.LatLng(pharmacies[i].lat, pharmacies[i].lng);
                        const marker = new google.maps.Marker({
                            position: latLng,
                            title: 'Φαρμακείο ' + pharmacies[i].name,
                            map: map,
                            icon: '{{ url('images/pharmacy_map_icon.png') }}'
                        });
                        const content = `
                            <div id="infowindow">
                                <span>Φαρμακείο ${pharmacies[i].name}</span><br>
                                <a href="${pharmacies[i].seo_url}" class="text-blue-500">Προβολή</a> |
                                <a href="tel:${pharmacies[i].phone}" class="text-blue-500">Τηλέφωνο</a> |
                                <a href="https://www.google.com/maps/dir/?api=1&destination=${pharmacies[i].lat},${pharmacies[i].lng}" target="_blank" class="text-blue-500">Οδηγίες</a>
                            </div>`;
                        marker.addListener("click", () => {
                            infoWindow.close();
                            infoWindow.setContent(content);
                            infoWindow.open(map, marker);
                        });
                        if (defaultTab !== 'all'){
                            marker.setVisible(false);
                        }
                        pharmacyMarkers.push(marker);

                    }

                    for (let i = 0; i < availables.length; i++) {
                        const latLng = new google.maps.LatLng(availables[i].lat, availables[i].lng);
                        const marker = new google.maps.Marker({
                            position: latLng,
                            title: 'Φαρμακείο ' + availables[i].name,
                            map: map,
                            icon: '{{ url('images/pharmacy_map_icon.png') }}'
                        });
                        const content = `
                            <div id="infowindow">
                                <span>Φαρμακείο ${availables[i].name}</span><br>
                                <a href="${availables[i].seo_url}" class="text-blue-500">Προβολή</a> |
                                <a href="tel:${availables[i].phone}" class="text-blue-500">Τηλέφωνο</a> |
                                <a href="https://www.google.com/maps/dir/?api=1&destination=${availables[i].lat},${availables[i].lng}" target="_blank" class="text-blue-500">Οδηγίες</a>
                            </div>`;
                        marker.addListener("click", () => {
                            infoWindow.close();
                            infoWindow.setContent(content);
                            infoWindow.open(map, marker);
                        });
                        if (defaultTab !== 'availables'){
                            marker.setVisible(false);
                        }
                        availableMarkers.push(marker);
                    }

                    for (let i = 0; i < withRapidTests.length; i++) {
                        const latLng = new google.maps.LatLng(withRapidTests[i].lat, withRapidTests[i].lng);
                        const marker = new google.maps.Marker({
                            position: latLng,
                            title: 'Φαρμακείο ' + withRapidTests[i].name,
                            map: map,
                            icon: '{{ url('images/pharmacy_map_icon.png') }}'
                        });
                        const content = `
                            <div id="infowindow">
                                <span>Φαρμακείο ${withRapidTests[i].name}</span><br>
                                <a href="${withRapidTests[i].seo_url}" class="text-blue-500">Προβολή</a> |
                                <a href="tel:${withRapidTests[i].phone}" class="text-blue-500">Τηλέφωνο</a> |
                                <a href="https://www.google.com/maps/dir/?api=1&destination=${withRapidTests[i].lat},${withRapidTests[i].lng}" target="_blank" class="text-blue-500">Οδηγίες</a>
                            </div>`;
                        marker.addListener("click", () => {
                            infoWindow.close();
                            infoWindow.setContent(content);
                            infoWindow.open(map, marker);
                        });
                        if (defaultTab !== 'rapid'){
                            marker.setVisible(false);
                        }
                        rapidTestMarkers.push(marker);
                    }

                    allPharmaciesCluster = new MarkerClusterer(map, pharmacyMarkers, {
                        imagePath:
                            "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
                    });

                    availablePharmaciesCluster = new MarkerClusterer(map, availableMarkers, {
                        imagePath:
                            "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
                    });

                    rapidTestCluster = new MarkerClusterer(map, rapidTestMarkers, {
                        imagePath:
                            "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
                    });

                    updateClusterVisibility(defaultTab)

                    ShowPharmaciesControl(centerControlDiv, defaultTab==='all');
                    ShowAvailablesControl(centerControlDiv, defaultTab==='availables');
                    ShowRapidTestsControl(centerControlDiv, defaultTab==='rapid')

                    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
                }
            </script>
        </x-slot>
    @endif
</x-guest-layout>
