<!DOCTYPE html>
<html lang="en">
<head>
    <title>Full Map</title>
    @if(!empty($maps_api_key))
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ $maps_api_key }}&callback=initMap&libraries=&v=weekly"
            defer
        ></script>
        <style type="text/css">
            /* Always set the map height explicitly to define the size of the div
             * element that contains the map. */
            #map {
                height: 100%;
            }

            /* Optional: Makes the sample page fill the window. */
            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        </style>
        <script>
            let map;

            @if(isset($locations) && is_array($locations) && count($locations) > 0)
            const coors = @json($locations)
            @endif

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: {lat: 35.121, lng: 33.406},
                    zoom: 10,
                });

                @if(isset($locations) && is_array($locations) && count($locations) > 0)
                for (let i = 0; i < coors.length; i++) {
                    const latLng = new google.maps.LatLng(coors[i].lat, coors[i].lng);
                    new google.maps.Marker({
                        position: latLng,
                        map: map,
                    });
                }
                @endif
            }
        </script>
    @endif
</head>
<body>
<div id="map"></div>
</body>
</html>
