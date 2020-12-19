<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;

class MapController extends Controller
{
    public function map()
    {
        return view('pages.map.index',
            [
                'pharmacies' => Pharmacy::all(),
                'maps_api_key' => config('googlemaps.api_key'),
            ]);
    }
}
