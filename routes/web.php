<?php

use App\Http\Controllers\Admin\PharmacyController as AdminPharmacyController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PharmacyController;
use App\Http\Livewire\RegionPage;
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

Route::view('/', 'homepage.index')->name('homepage');

Route::get('/farmakeia-{region}', RegionPage::class)->name('farmakeia');

Route::get('/{am}/farmakeio-{slug}', [PharmacyController::class, 'pharmacy'])->name('farmakeio');
Route::get('/map', [MapController::class, 'map'])->name('map');
Route::get('/map/rapid-tests', [MapController::class, 'map'])->name('rapid-tests');

Route::view('/sxetika/pos-leitourgei', 'pos-leitourgei')->name('how-it-works');
Route::view('/sxetika/politiki-aporritou', 'politiki-aporritou')->name('privacy-policy');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::resource('pharmacies', AdminPharmacyController::class);
    });

Route::view('/dashboard', 'admin.dashboard')
    ->middleware(['auth:sanctum', 'verified'])
    ->name('dashboard');
