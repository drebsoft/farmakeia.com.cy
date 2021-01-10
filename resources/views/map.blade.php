<x-guest-layout>
    <x-slot name="headerSlot">
        <title>Χάρτης φαρμακείων της Κύπρου</title>
    </x-slot>

    <x-slot name="extrastyles">
        <style>
            .custom-default-map-button {
                background-image: none;
                background-clip: padding-box;
                background-color: rgb(255, 255, 255);
                display: table-cell;
                border: 0px;
                margin: 0px;
                padding: 0px 17px;
                text-transform: none;
                -webkit-appearance: none;
                position: relative;
                cursor: pointer;
                -webkit-user-select: none;
                direction: ltr;
                overflow: hidden;
                text-align: center;
                height: 40px;
                vertical-align: middle;
                color: rgb(86, 86, 86);
                font-family: Roboto, Arial, sans-serif;
                font-size: 18px;
                border-bottom-left-radius: 2px;
                border-top-left-radius: 2px;
                -webkit-background-clip: padding-box;
                -webkit-box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px;
                box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px;
                min-width: 36px;
                background-position: initial initial;
                background-repeat: initial initial;
            }

            .custom-active-map-button {
                font-weight: 500;
                color: rgb(0, 0, 0);
            }

            .custom-default-map-button:hover,
            .custom-active-map-button:hover {
                background-color: rgb(235, 235, 235);
                color: rgb(0, 0, 0);
            }
        </style>
    </x-slot>

    @if(!empty($maps_api_key))
        <x-slot name="scriptloads">
            <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
            <script
                src="https://maps.googleapis.com/maps/api/js?key={{ $maps_api_key }}&callback=initMap&libraries=&v=weekly"
                defer
            ></script>
        </x-slot>
    @endif

    <div id="map" style="height: 75vh"></div>

    @if(!empty($maps_api_key))
        <x-slot name="scripts">
            <script>
                let map;

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
                        for (let i = 0; i < pharmacyMarkers.length; i++) {
                            pharmacyMarkers[i].setVisible(true);
                            document.getElementById('custom-map-button-for-all').className = "custom-default-map-button custom-active-map-button"
                        }
                        for (let i = 0; i < availableMarkers.length; i++) {
                            availableMarkers[i].setVisible(false);
                            document.getElementById('custom-map-button-for-available').className = "custom-default-map-button"
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
                        for (let i = 0; i < pharmacyMarkers.length; i++) {
                            pharmacyMarkers[i].setVisible(false);
                            document.getElementById('custom-map-button-for-all').className = "custom-default-map-button"
                        }
                        for (let i = 0; i < availableMarkers.length; i++) {
                            availableMarkers[i].setVisible(true);
                            document.getElementById('custom-map-button-for-available').className = "custom-default-map-button custom-active-map-button"
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
                        @if(!empty($availables) && $availables->count() > 0)
                        marker.setVisible(false);
                        @endif
                        pharmacyMarkers.push(marker);
                    }

                    for (let i = 0; i < availables.length; i++) {
                        const latLng = new google.maps.LatLng(availables[i].lat, availables[i].lng);
                        const marker = new google.maps.Marker({
                            position: latLng,
                            title: 'Φαρμακείο ' + availables[i].name,
                            map: map,
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
                        availableMarkers.push(marker);
                    }

                    @if(!empty($availables) && $availables->count() > 0)
                    ShowPharmaciesControl(centerControlDiv, false);
                    ShowAvailablesControl(centerControlDiv, true);
                    @else
                    ShowPharmaciesControl(centerControlDiv, true);
                    ShowAvailablesControl(centerControlDiv, false);
                    @endif

                    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
                }
            </script>
        </x-slot>
    @endif
</x-guest-layout>
