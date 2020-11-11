<?php

namespace App\Console\Commands;

use App\Actions\Importer\ParsePharmacyListExcelFiles;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportExcelFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pharmacies:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports the pharmacy data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        app(ParsePharmacyListExcelFiles::class)->handle(
            collect(File::files(storage_path('app/mohfiles')))
        );

        return 1;
    }
}
