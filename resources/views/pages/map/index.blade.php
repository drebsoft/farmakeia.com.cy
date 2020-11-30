<x-guest-layout>
    @if(!empty($maps_api_key))
        <x-slot name="scriptloads">
            <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
            <script
                src="https://maps.googleapis.com/maps/api/js?key={{ $maps_api_key }}&callback=initMap&libraries=&v=weekly"
                defer
            ></script>
        </x-slot>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div id="map" style="height: 600px"></div>
            </div>
        </div>
    </div>

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
                        zoom: 10,
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
                        marker.addListener("click", () => {
                            infoWindow.close();
                            infoWindow.setContent(`<div id="infowindow">Φαρμακείο ${pharmacies[i].name}</div>`);
                            infoWindow.open(map, marker);
                        });
                    }
                    @endif
                }
            </script>
        </x-slot>
    @endif
</x-guest-layout>
