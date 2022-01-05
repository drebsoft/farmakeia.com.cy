<?php

namespace App\Console\Commands;

use App\Actions\Importer\PharmacyExcelParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UpdatePharmacyAvailability extends Command
{
    protected $signature = 'pharmacies:update-availability';

    protected $description = 'Updates the pharmacy availability';

    public function handle()
    {
        $files = collect(File::glob(storage_path('app/mohfiles/*.csv')));
        $filecount = $files->count();

        $this->info('Found a total of ' . $filecount . ' to parse.');
        $this->info('====================');

        $filesparsed = 0;

        $files->each(function (string $filePath) use (&$filesparsed) {

            $fileName = Str::afterLast($filePath, '/');
            $period = Str::before($fileName, '_');
            $city = Str::beforeLast(Str::afterLast($fileName, 'City_'), '.csv');

            $this->info('Parsing file for ' . $city . ' (' . $period . ')');

            $parser = new PharmacyExcelParser($city);
            $parser->withOutput($this->output)->import($filePath, null, \Maatwebsite\Excel\Excel::CSV);
            $counts = $parser->getCounts();

            $this->info('Parsed a total of ' . $counts['rows'] . ' rows (' . $counts['failed'] . ' failed).');
            $this->info('Pharmacies: ' . $counts['pharmacies']['added'] . ' added / ' . $counts['pharmacies']['updated'] . ' updated / ' . $counts['pharmacies']['alreadyFine'] . ' already fine.');
            $this->info('Availabilities: ' . $counts['availabilities']['added'] . ' added / ' . $counts['availabilities']['updated'] . ' updated / ' . $counts['availabilities']['alreadyFine'] . ' already fine.');

            $filesparsed++;

            $this->info('');
            $this->info('========================================');
            $this->info('');
        });

        $this->info('Parsed ' . $filesparsed . '/' . $filecount . ' files.');

        return 0;
    }
}
