<?php

namespace App\Http\Livewire;

use App\Models\Availability;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RegionPage extends Component
{
    use WithPagination;

    protected $regionMap = [
        'lefkosia' => 'Nicosia',
        'lemesos' => 'Limassol',
        'larnaka' => 'Larnaca',
        'paphos' => 'Paphos',
        'paralimni' => 'Paralimni',
    ];

    protected $regionSeo = [
        'lefkosia' => 'Βρείτε εδώ τα εφημερεύοντα φαρμακεία για ολόκληρη την επαρχία Λευκωσίας. Σε αυτή τη σελίδα θα βρείτε κάθε φαρμακείο στη Λευκωσία, μαζί με τις επόμενες εφημερίες τους για τους επόμενους μήνες. Δείτε τις ακριβείς διευθύνσεις και την περιοχή τους. Καλέστε απευθείας το φαρμακείο που επιθυμείτε από το κινητό σας τηλέφωνο. Ανοίξτε τα φαρμακεία στο χάρτη και δείτε ποια εφημερεύουν.',
        'lemesos' => 'Όλα τα εφημερεύοντα φαρμακεία της Λεμεσού στη διάθεσή σας. Δείτε την πλήρη λίστα με τα φαρμακεία που εφημερεύουν στην επαρχία Λεμεσού. Βρείτε τηλέφωνα επικοινωνίας και οικίας για κάθε φαρμακείο. Στην κάθε σελίδα υπάρχει η διεύθυνση και οι επόμενες εφημερίες του φαρμακείου που έχετε επιλέξει να ανοίξετε. Βρείτε το σημείο στο χάρτη και λάβετε οδηγίες.',
        'larnaka' => 'Αναζητήστε φαρμακεία στις Φοινικούδες και την ευρύτερη επαρχία της Λάρνακας. Δείτε αναλυτικά τα στοιχεία όπως η διεύθυνση και το τηλέφωνο, αλλά και τις εφημερίες κάθε φαρμακείου. Ενημερωθείτε με μια ματιά για τα εφημερεύοντα φαρμακεία της Λάρνακας. Βρείτε όλα τα φαρμακεία που εφημερεύουν σήμερα ή τις επόμενες μέρες και διαβάστε όλες τις πληροφορίες τους.',
        'paphos' => 'Ενημερωθείτε για τα φαρμακεία που εφημερεύουν στην Πάφο. Βρείτε γρήγορα το εφημερεύον φαρμακείο που σας εξυπηρετεί και δείτε με μια ματιά όλα του τα στοιχεία. Μάθετε το τηλέφωνο ή την ακριβή διεύθυνση και ενημερωθείτε για τις επόμενες εφημερίες που θα έχει κάθε φαρμακείο στην επαρχία της Πάφου. Δείτε τη λίστα με τα φαρμακεία και διαλέξτε αυτό που σας εξυπηρετεί.',
        'paralimni' => 'Τα εφημερεύοντα φαρμακεία της του Παραλιμνίου και της Ελεύθερης Περιοχής Αμμοχώστου σας περιμένουν σε αυτή τη σελίδα. Δείτε την πλήρη λίστα με τα φαρμακεία που εφημερεύουν σήμερα στο Παραλίμνι και την Άγια Νάπα, όπως επίσης και στον Πρωταρά. Βρείτε τηλέφωνα επικοινωνίας και διευθύνσεις για όλα τα φαρμακεία. Μάθετε τις επόμενες εφημερίες που θα έχει κάθε φαρμακείο.',
    ];

    protected $pharmacies;

    public $search;

    public $rapid_tests_only = false;

    public $page = 1;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'rapid_tests_only' => ['except' => false]
    ];

    public $selectedRegion;

    public function mount($region)
    {
        $this->selectedRegion = strtolower($region);
        $this->fill(request()->only('search'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleRapidTests()
    {
        $this->rapid_tests_only = !$this->rapid_tests_only;
    }

    public function render()
    {
        $this->pharmacies = [];

        if (in_array($this->selectedRegion, array_keys($this->regionMap))) {
            $this->refreshPharmacies();
        }

        return view('livewire.region-page', [
            'pharmacies' => $this->pharmacies,
            'region' => $this->regionMap[$this->selectedRegion] ?? null,
            'regionSeo' => $this->regionSeo[$this->selectedRegion] ?? null,
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
                    $query->where(function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('address', 'like', '%' . $this->search . '%');
                    });
                }
            })
            ->where('region', $this->regionMap[$this->selectedRegion])
            ->when($this->rapid_tests_only, function ($query) {
                $query->where('does_rapid_tests', true);
            })
            ->orderByRaw('CASE WHEN next_availability IS NULL THEN 1 ELSE 0 END')
            ->orderBy('next_availability')
            ->paginate();
    }

    public function updatedPage()
    {
        $this->emit('pageChanged');
    }
}
