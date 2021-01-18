<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function map()
    {
        $pharmacies = Pharmacy::query()
                              ->addSelect([
                                  'next_availability' => Availability::select(DB::raw("DATE_FORMAT(date, '%Y-%m-%d') AS date"))
                                                                     ->whereColumn('pharmacy_id', 'pharmacies.id')
                                                                     ->where(DB::raw("DATE_FORMAT(date, '%Y-%m-%d')"),
                                                                         ">=",
                                                                         DB::raw('CURRENT_DATE()'))
                                                                     ->orderBy('date')
                                                                     ->limit(1),
                              ])->get();
        $availables = $pharmacies->where('next_availability', now()->format('Y-m-d'))->values();
        return view('map',
            [
                'pharmacies' => $pharmacies,
                'availables' => $availables,
                'maps_api_key' => config('googlemaps.api_key'),
            ]);
    }
}
