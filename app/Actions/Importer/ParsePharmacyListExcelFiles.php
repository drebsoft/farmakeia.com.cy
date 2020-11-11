<?php namespace App\Actions\Importer;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ParsePharmacyListExcelFiles
{
    public function handle(Collection $files)
    {
        $files->map(function (string $filePath) {
            Excel::import(new PharmacyExcelParser, $filePath);
        });
    }
}
