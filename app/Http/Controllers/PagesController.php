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
        $pharmacies = [];

        if (in_array($region, array_keys($this->regionMap))) {
            $pharmacies = Pharmacy::where('region', $this->regionMap[$region])->get()->sortByDesc('is_available');
        }

        return view('pages.pharmacies.index',
            [
                'pharmacies' => $pharmacies,
                'region' => $this->regionMap[$region] ?? null
            ]);
    }

    public function pharmacy(string $am)
    {
        $pharmacy = Pharmacy::where('am', $am)->first();

        if (!$pharmacy) {
            return view('pages.pharmacies.not_found');
        }

        $nextAvailabilities = $pharmacy->futureAvailabilities();

        return view('pages.pharmacies.single', [
            'pharmacy' => $pharmacy,
            'nextAvailabilities' => $nextAvailabilities
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

    public function about(string $page)
    {
        $view = 'pages.about.' . strtolower($page);

        return view()->exists($view) ? view($view) : redirect(route('homepage'));
    }
}
