<?php

namespace App\Http\Controllers;

use App\Models\Availability;

class ApiController extends Controller
{
    public function availablePharmacies()
    {
        return response()->json(
            Availability::query()
                ->where('date', now()->format('Y-m-d'))
                ->with('pharmacy')
                ->get()
                ->pluck('pharmacy')
        );
    }
}
