<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key
    |--------------------------------------------------------------------------
    |
    | Here you may specify which key in the env file holds the value of your
    | API key for Google Maps (and possibly other Google services). It is
    | very important to remember to set up billing for the key to work.
    |
    */

    'api_key' => env('MAPS_API_KEY', ''),
    'server_api_key' => env('MAPS_SERVER_API_KEY', ''),
];
