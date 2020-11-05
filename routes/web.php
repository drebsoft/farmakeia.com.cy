<?php

use App\Services\Geocoding;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::view('map', 'map', [
    'maps_api_key' => config('googlemaps.api_key'),
    'locations' => [
        (new Geocoding)->translate('Iremias 17, Lakatamia, Nicosia')->toCoordinates()->getCoordinatesArray(),
        (new Geocoding)->translate('11 Vyzantiou and 52A Agiou Mamantos, Lakatamia, Nicosia')->toCoordinates()->getCoordinatesArray(),
    ],
]);
Route::view('single', 'single', [
    'maps_api_key' => config('googlemaps.api_key'),
    'location' => Str::of('Iremias 17, Lakatamia, Nicosia')->replace(' ', '+'),
]);
