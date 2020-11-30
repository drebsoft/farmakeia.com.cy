<?php

namespace App\Console\Commands;

use App\Actions\Importer\PharmacyExcelParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class UpdatePharmacyAvailability extends Command
{
    protected $signature = 'pharmacies:update-availability';

    protected $description = 'Updates the pharmacy availability';

    public function handle()
    {
        collect(File::glob(storage_path('app/mohfiles/City_*')))
            ->each(function (string $filePath) {
                $city = Str::beforeLast(Str::afterLast($filePath, 'City_'), '.csv');

                Excel::import(new PharmacyExcelParser($city), $filePath, null, \Maatwebsite\Excel\Excel::CSV);
            });

        return 1;
    }
}
