@if(!empty($maps_api_key) && !empty($location))
    <iframe
        width="650" height="400"
        style="border:0"
        src="https://www.google.com/maps/embed/v1/place?key={{ $maps_api_key }}
            &q={{ Str::of($location)->replace(' ', '+') }}&region=cy" allowfullscreen>
    </iframe>
@endif
