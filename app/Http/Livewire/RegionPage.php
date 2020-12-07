<?php

namespace App\Http\Livewire;

use App\Models\Availability;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\DB;
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

    protected $pharmacies;

    public $search;

    public $page = 1;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public $selectedRegion;

    public function mount($region)
    {
        $this->selectedRegion = strtolower($region);
        $this->fill(request()->only('search'));
    }

    public function render()
    {
        $this->pharmacies = [];

        if (in_array($this->selectedRegion, array_keys($this->regionMap))) {
            $this->refreshPharmacies();
        }

        return view('livewire.region-page', [
            'pharmacies' => $this->pharmacies,
            'region' => $this->regionMap[$this->selectedRegion] ?? null
        ])->layout('layouts.guest');
    }

    protected function refreshPharmacies()
    {
        $this->pharmacies = Pharmacy::query()
            ->addSelect(['next_availability' => Availability::select(DB::raw("DATE_FORMAT(date, '%Y-%m-%d') AS date"))
                ->whereColumn('pharmacy_id', 'pharmacies.id')
                ->where(DB::raw("DATE_FORMAT(date, '%Y-%m-%d')"), ">=", DB::raw('CURRENT_DATE()'))
                ->orderBy('date')
                ->limit(1)
            ])
            ->tap(function ($query) {
                if (!empty($this->search)) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                }
            })
            ->where('region', $this->regionMap[$this->selectedRegion])
            ->orderBy('next_availability')
            ->paginate();
    }
}
