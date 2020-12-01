<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;

class PagesController extends Controller
{
    protected $regionMap = [
        'lefkosia' => 'Nicosia',
        'lemesos' => 'Limassol',
        'larnaka' => 'Larnaca',
        'paphos' => 'Paphos',
        'paralimni' => 'Paralimni',
    ];

    public function homepage()
    {
        return view('pages.homepage.index');
    }

    public function pharmacies(string $region)
    {
        $region = strtolower($region);

        return view('pages.pharmacies.index',
            ['pharmacies' => Pharmacy::where('region', $this->regionMap[$region])->get()]);
    }

    public function pharmacy(string $am)
    {
        return view('pages.pharmacies.single',
            [
                'pharmacy' => Pharmacy::where('am', $am)->first(),
                'maps_api_key' => config('googlemaps.api_key'),
            ]);
    }

    public function map()
    {
        return view('pages.map.index',
            [
                'pharmacies' => Pharmacy::all(),
                'maps_api_key' => config('googlemaps.api_key'),
            ]);
    }
}
