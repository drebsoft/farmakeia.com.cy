<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Facebook Configuration Values
    |--------------------------------------------------------------------------
    |
    | This is the configuration options and values needed for the proper
    | function of the Facebook PHP SDK as that is needed to correctly
    | submit and relay any posts we might need to our actual Page.
    |
    */

    'page_id' => env('FB_PAGE_ID'),
    'app_id' => env('FB_APP_ID'),
    'app_secret' => env('FB_APP_SECRET'),
    'default_graph_version' => 'v2.10',
    'default_access_token' => env('FB_ACCESS_TOKEN'),

];
