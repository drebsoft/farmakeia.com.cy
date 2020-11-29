<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    private $regionMap;

    public function __construct()
    {
        $this->regionMap = [
            'lefkosia' => 'Nicosia',
            'lemesos' => 'Limassol',
            'larnaka' => 'Larnaca',
            'pafos' => 'Pafos',
            'paralimni' => 'Paralimni',
        ];
    }

    public function homepage()
    {
        return view('pages.homepage.index');
    }

    public function pharmacies(string $region)
    {
        return view('pages.pharmacies.index',
            ['pharmacies' => Pharmacy::where('region', $this->regionMap[$region])->get()]);
    }

    public function pharmacy(string $am)
    {
        return view('pages.pharmacies.single',
            ['pharmacy' => Pharmacy::where('am', $am)->first()]);
    }
}