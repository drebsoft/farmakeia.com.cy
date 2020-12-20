<?php

use App\Http\Controllers\Admin\PharmacyController as AdminPharmacyController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PharmacyController;
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

Route::get('/{am}/farmakeio-{name}', [PharmacyController::class, 'pharmacy'])->name('farmakeio');
Route::get('/map', [MapController::class, 'map'])->name('map');

Route::view('/sxetika/pos-leitourgei', 'pages.about.pos-leitourgei')->name('how-it-works');
Route::view('/sxetika/politiki-aporritou', 'pages.about.politiki-aporritou')->name('privacy-policy');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::resource('pharmacies', AdminPharmacyController::class);
    });

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
