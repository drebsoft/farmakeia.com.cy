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

                const pharmacies = @json((!empty($pharmacies) && $pharmacies->count() > 0) ? $pharmacies : []);
                let pharmacyMarkers = [];
                function ShowPharmaciesControl(controlDiv) {
                    // Set CSS for the control interior.
                    const controlText = document.createElement("div");
                    controlText.style.backgroundClip = "padding-box";
                    controlText.style.backgroundColor = "rgb(235, 235, 235)";
                    controlText.style.display = "table-cell";
                    controlText.style.border = "0px";
                    controlText.style.margin = "0px";
                    controlText.style.padding = "0px 17px";
                    controlText.style.textTransform = "none";
                    controlText.style.webkitAppearance = "none";
                    controlText.style.position = "relative";
                    controlText.style.cursor = "pointer";
                    controlText.style.webkitUserSelect = "none";
                    controlText.style.direction = "ltr";
                    controlText.style.overflow = "hidden";
                    controlText.style.textAlign = "center";
                    controlText.style.height = "40px";
                    controlText.style.verticalAlign = "middle";
                    controlText.style.color = "rgb(0, 0, 0)";
                    controlText.style.fontFamily = "Roboto, Arial, sans-serif";
                    controlText.style.fontSize = "18px";
                    controlText.style.borderBottomLeftRadius = "2px";
                    controlText.style.borderTopLeftRadius = "2px";
                    controlText.style.webkitBackgroundClip = "padding-box";
                    controlText.style.webkitBoxShadow = "rgba(0, 0, 0, 0.3) 0px 1px 4px -1px";
                    controlText.style.boxShadow = "rgba(0, 0, 0, 0.3) 0px 1px 4px -1px";
                    controlText.style.minWidth = "36px";
                    controlText.style.fontWeight = "500";
                    controlText.style.backgroundPosition = "initial initial";
                    controlText.style.backgroundRepeat = "initial initial";
                    controlText.className = "test qwerty";
                    controlText.innerHTML = "Όλα";
                    controlText.title = "Πατήστε για προβολή όλων των φαρμακείων";
                    controlDiv.appendChild(controlText);
                    // Setup the click event listeners: simply set the map to Chicago.
                    controlText.addEventListener("click", () => {
                        for (let i = 0; i < pharmacyMarkers.length; i++) {
                            pharmacyMarkers[i].setVisible(true);
                        }
                        for (let i = 0; i < availableMarkers.length; i++) {
                            availableMarkers[i].setVisible(false);
                        }
                    });
                }

                const availables = @json((!empty($availables) && $availables->count() > 0) ? $availables : []);
                let availableMarkers = [];
                function ShowAvailablesControl(controlDiv) {
                    // Set CSS for the control interior.
                    const controlText = document.createElement("div");
                    controlText.style.backgroundImage = "none";
                    controlText.style.backgroundClip = "padding-box";
                    controlText.style.backgroundColor = "rgb(255, 255, 255)";
                    controlText.style.display = "table-cell";
                    controlText.style.border = "0px";
                    controlText.style.margin = "0px";
                    controlText.style.padding = "0px 17px";
                    controlText.style.textTransform = "none";
                    controlText.style.webkitAppearance = "none";
                    controlText.style.position = "relative";
                    controlText.style.cursor = "pointer";
                    controlText.style.webkitUserSelect = "none";
                    controlText.style.direction = "ltr";
                    controlText.style.overflow = "hidden";
                    controlText.style.textAlign = "center";
                    controlText.style.height = "40px";
                    controlText.style.verticalAlign = "middle";
                    controlText.style.color = "rgb(86, 86, 86)";
                    controlText.style.fontFamily = "Roboto, Arial, sans-serif";
                    controlText.style.fontSize = "18px";
                    controlText.style.borderBottomLeftRadius = "2px";
                    controlText.style.borderTopRightRadius = "2px";
                    controlText.style.webkitBackgroundClip = "padding-box";
                    controlText.style.webkitBoxShadow = "rgba(0, 0, 0, 0.3) 0px 1px 4px -1px";
                    controlText.style.boxShadow = "rgba(0, 0, 0, 0.3) 0px 1px 4px -1px";
                    controlText.style.minWidth = "66px";
                    controlText.style.backgroundPosition = "initial initial";
                    controlText.style.backgroundRepeat = "initial initial";
                    controlText.innerHTML = "Εφημερεύοντα";
                    controlText.title = "Πατήστε για προβολή των εφημερεύοντων φαρμακείων";
                    controlDiv.appendChild(controlText);
                    // Setup the click event listeners: simply set the map to Chicago.
                    controlText.addEventListener("click", () => {
                        for (let i = 0; i < pharmacyMarkers.length; i++) {
                            pharmacyMarkers[i].setVisible(false);
                        }
                        for (let i = 0; i < availableMarkers.length; i++) {
                            availableMarkers[i].setVisible(true);
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
                    centerControlDiv.style.backgroundColor = "#fff";
                    centerControlDiv.style.border = "2px solid #fff";
                    centerControlDiv.style.borderRadius = "3px";
                    centerControlDiv.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
                    centerControlDiv.style.cursor = "pointer";
                    centerControlDiv.style.marginBottom = "5px";
                    centerControlDiv.style.textAlign = "center";

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
                    ShowPharmaciesControl(centerControlDiv);

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
                    ShowAvailablesControl(centerControlDiv);

                    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
                }
            </script>
        </x-slot>
    @endif
</x-guest-layout>
