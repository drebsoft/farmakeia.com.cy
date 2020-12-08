<?php

namespace App\Console\Commands;

use App\Models\Pharmacy;
use App\Services\Geocoding;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FillCoordinatesForPharmacies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pharmacies:fill-coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tries to fill the coordinates for Pharmacies that don\'t have any';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pharmacies = Pharmacy::query()->whereNull(['lat', 'lng'])->get();
        $missing = $pharmacies->count();
        $this->info('Found a total of ' . $missing . ' pharmacies without coordinates.');
        $found = 0;
        $not_found = 0;
        $updated = 0;
        $failed = 0;
        foreach ($pharmacies as $pharmacy) {
            try {
                $coordinates = (new Geocoding)->translate($pharmacy->map_address)->toCoordinates()->getCoordinatesArray();
                if (empty($coordinates)) {
                    $not_found++;
                    continue;
                }
                $found++;
                $pharmacy->update($coordinates);
                $updated++;
            } catch (\Exception $e) {
                $failed++;
                Log::debug($e->getMessage(), $e->getTrace());
            }
        }
        $this->info('Found coordinates for ' . $found . ' of them and managed to update ' . $updated . '.');
        $this->info('No coordinates were found for ' . $not_found . ' and there were ' . $failed . ' failures.');
        return 0;
    }
}
