<?php

namespace App\Http\Livewire;

use App\Models\Pharmacy;
use Livewire\Component;

class RegionPage extends Component
{
    protected $regionMap = [
        'lefkosia' => 'Nicosia',
        'lemesos' => 'Limassol',
        'larnaka' => 'Larnaca',
        'paphos' => 'Paphos',
        'paralimni' => 'Paralimni',
    ];

    public $pharmacies;
    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $selectedRegion;

    public function mount($region)
    {
        $this->selectedRegion = strtolower($region);

        if (!in_array($this->selectedRegion, array_keys($this->regionMap))) {
            abort(404);
        }
    }

    public function render()
    {
        $this->refreshPharmacies();

        return view('livewire.region-page', [
            'region' => $this->regionMap[$this->selectedRegion] ?? null
        ])->layout('layouts.guest');
    }

    protected function refreshPharmacies()
    {
        $this->pharmacies = Pharmacy::where('name', 'like', '%' . $this->search . '%')
            ->where('region', $this->regionMap[$this->selectedRegion])
            ->get()
            ->sortByDesc('is_available');
    }
}
