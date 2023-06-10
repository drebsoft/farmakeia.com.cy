<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
