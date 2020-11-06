<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePharmacy;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PharmacyController extends Controller
{

    public function index()
    {
        $pharmacies = Pharmacy::all();
        return view('pharmacies.index', compact('pharmacies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('pharmacies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePharmacy  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePharmacy $request)
    {
        $validated = $request->validated();
        Pharmacy::create($validated);
        return redirect('/pharmacies');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function show(Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Pharmacy $pharmacy)
    {
        return view('pharmacies.edit', compact('pharmacy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StorePharmacy  $request
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StorePharmacy $request, Pharmacy $pharmacy)
    {
        $validated = $request->validated();
        $pharmacy->update($validated);

        return redirect('/pharmacies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pharmacy $pharmacy)
    {
        //
    }
}
