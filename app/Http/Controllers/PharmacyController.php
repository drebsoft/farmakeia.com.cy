<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;

class PharmacyController extends Controller
{
    public function pharmacy($am, $slug)
    {
        $pharmacy = Pharmacy::where('am', $am)->where('slug', $slug)->first();

        if (!$pharmacy) {
            return response()->view('pharmacies.not_found', [], 404);
        }

        $nextAvailabilities = $pharmacy->futureAvailabilities();

        return view('pharmacies.single', [
            'pharmacy' => $pharmacy,
            'nextAvailabilities' => $nextAvailabilities
        ]);
    }
}
