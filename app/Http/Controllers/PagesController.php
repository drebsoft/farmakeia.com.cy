<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;

class PagesController extends Controller
{
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
