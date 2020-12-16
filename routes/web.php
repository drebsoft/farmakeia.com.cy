<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PharmacyController;
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

Route::view('/', 'pages.homepage.index')->name('homepage');

Route::get('/farmakeia-{region}', \App\Http\Livewire\RegionPage::class)->name('farmakeia');

Route::get('/{am}/farmakeio-{name}', [PagesController::class, 'pharmacy'])->name('farmakeio');
Route::get('/map', [PagesController::class, 'map'])->name('map');

Route::view('/sxetika/pos-leitourgei', 'pages.about.pos-leitourgei')->name('how-it-works');
Route::view('/sxetika/politiki-aporritou', 'pages.about.politiki-aporritou')->name('privacy-policy');

Route::get('/pharmacies', [PharmacyController::class, 'index']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::resource('pharmacies', PharmacyController::class)->except(['index']);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
