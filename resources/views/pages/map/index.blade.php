<x-guest-layout>
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
        </x-slot>
    @endif

    <div id="map" style="height: 100vh"></div>

    @if(!empty($maps_api_key))
        <x-slot name="scripts">
            <script>
                let map;

                @if(!empty($pharmacies))
                const pharmacies = @json($pharmacies);
                let pharmacyMarkers = [];
                function ShowPharmaciesControl(controlDiv) {
                    // Set CSS for the control border.
                    const controlUI = document.createElement("div");
                    controlUI.style.backgroundColor = "#fff";
                    controlUI.style.border = "2px solid #fff";
                    controlUI.style.borderRadius = "3px";
                    controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
                    controlUI.style.cursor = "pointer";
                    controlUI.style.marginBottom = "22px";
                    controlUI.style.textAlign = "center";
                    controlUI.title = "Πατήστε για προβολή όλων των φαρμακείων";
                    controlDiv.appendChild(controlUI);
                    // Set CSS for the control interior.
                    const controlText = document.createElement("div");
                    controlText.style.color = "rgb(25,25,25)";
                    controlText.style.fontFamily = "Roboto,Arial,sans-serif";
                    controlText.style.fontSize = "16px";
                    controlText.style.lineHeight = "38px";
                    controlText.style.paddingLeft = "5px";
                    controlText.style.paddingRight = "5px";
                    controlText.innerHTML = "Όλα";
                    controlUI.appendChild(controlText);
                    // Setup the click event listeners: simply set the map to Chicago.
                    controlUI.addEventListener("click", () => {
                        for (let i = 0; i < pharmacyMarkers.length; i++) {
                            pharmacyMarkers[i].setVisible(true);
                        }
                        for (let i = 0; i < availableMarkers.length; i++) {
                            availableMarkers[i].setVisible(false);
                        }
                    });
                }
                @endif
                @if(!empty($availables))
                const availables = @json($availables);
                let availableMarkers = [];
                function ShowAvailablesControl(controlDiv) {
                    // Set CSS for the control border.
                    const controlUI = document.createElement("div");
                    controlUI.style.backgroundColor = "#fff";
                    controlUI.style.border = "2px solid #fff";
                    controlUI.style.borderRadius = "3px";
                    controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
                    controlUI.style.cursor = "pointer";
                    controlUI.style.marginBottom = "22px";
                    controlUI.style.textAlign = "center";
                    controlUI.title = "Πατήστε για προβολή των εφημερεύοντων φαρμακείων";
                    controlDiv.appendChild(controlUI);
                    // Set CSS for the control interior.
                    const controlText = document.createElement("div");
                    controlText.style.color = "rgb(25,25,25)";
                    controlText.style.fontFamily = "Roboto,Arial,sans-serif";
                    controlText.style.fontSize = "16px";
                    controlText.style.lineHeight = "38px";
                    controlText.style.paddingLeft = "5px";
                    controlText.style.paddingRight = "5px";
                    controlText.innerHTML = "Εφημερεύοντα";
                    controlUI.appendChild(controlText);
                    // Setup the click event listeners: simply set the map to Chicago.
                    controlUI.addEventListener("click", () => {
                        for (let i = 0; i < pharmacyMarkers.length; i++) {
                            pharmacyMarkers[i].setVisible(false);
                        }
                        for (let i = 0; i < availableMarkers.length; i++) {
                            availableMarkers[i].setVisible(true);
                        }
                    });
                }
                @endif

                function initMap() {
                    map = new google.maps.Map(document.getElementById("map"), {
                        center: {lat: 35.121, lng: 33.406},
                        zoom: 9,
                    });

                    const infoWindow = new google.maps.InfoWindow();
                    const centerControlDiv = document.createElement("div");

                    @if(!empty($pharmacies))
                    console.log(pharmacies);
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
                        @if(!empty($availables))
                        marker.setVisible(false);
                        @endif
                        pharmacyMarkers.push(marker);
                    }
                    ShowPharmaciesControl(centerControlDiv);
                    @endif

                    @if(!empty($availables))
                    console.log(availables);
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
                        console.log(availables[i]);
                        availableMarkers.push(marker);
                    }
                    ShowAvailablesControl(centerControlDiv);
                    @endif

                    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
                    console.log(pharmacyMarkers, availableMarkers);
                }
            </script>
        </x-slot>
    @endif
</x-guest-layout>
