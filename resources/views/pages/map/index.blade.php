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
                const pharmacies = @json($pharmacies)
                @endif

                function initMap() {
                    map = new google.maps.Map(document.getElementById("map"), {
                        center: {lat: 35.121, lng: 33.406},
                        zoom: 9,
                    });

                    const infoWindow = new google.maps.InfoWindow();

                    @if(!empty($pharmacies))
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
                    }
                    @endif
                }
            </script>
        </x-slot>
    @endif
</x-guest-layout>
