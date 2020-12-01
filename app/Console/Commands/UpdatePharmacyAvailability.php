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
        $files = collect(File::glob(storage_path('app/mohfiles/City_*')));
        $filecount = $files->count();
        $this->info('Found a total of ' . $filecount . ' to parse.');
        $this->info('====================');
        $filesparsed = 0;
        $files->each(function (string $filePath) use (&$filesparsed) {
            $city = Str::beforeLast(Str::afterLast($filePath, 'City_'), '.csv');
            $this->info('Parsing file for ' . $city);
            $parser = new PharmacyExcelParser($city);
            Excel::import($parser, $filePath, null, \Maatwebsite\Excel\Excel::CSV);
            $counts = $parser->getCounts();
            $this->info('Parsed a total of ' . $counts['rows'] . ' rows (' . $counts['failed'] . ' failed).');
            $this->info('Pharmacies: ' . $counts['pharmacies']['added'] . ' added / ' . $counts['pharmacies']['updated'] . ' updated / ' . $counts['pharmacies']['alreadyFine'] . ' already fine.');
            $this->info('Availabilities: ' . $counts['availabilities']['added'] . ' added / ' . $counts['availabilities']['updated'] . ' updated / ' . $counts['availabilities']['alreadyFine'] . ' already fine.');
            $filesparsed++;
            $this->info('====================');
        });
        $this->info('Parsed ' . $filesparsed . '/' . $filecount . ' files.');
        return 0;
    }
}
