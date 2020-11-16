<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdatePharmacyRequest;
use App\Models\Pharmacy;

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
     * @param  \App\Http\Requests\CreateUpdatePharmacyRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUpdatePharmacyRequest $request)
    {
        $validated = $request->validated();
        Pharmacy::create($validated);
        return redirect('/pharmacies');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Pharmacy $pharmacy)
    {
        return view('pharmacies.show', compact('pharmacy'));
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
     * @param  \App\Http\Requests\CreateUpdatePharmacyRequest  $request
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateUpdatePharmacyRequest $request, Pharmacy $pharmacy)
    {
        $validated = $request->validated();
        $pharmacy->update($validated);

        return redirect('/pharmacies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacy  $pharmacy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pharmacy $pharmacy)
    {
        $pharmacy->delete();
        return redirect('/pharmacies');
    }
}
