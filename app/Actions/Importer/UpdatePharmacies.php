<?php


namespace App\Actions\Importer;


class UpdatePharmacies
{
    public function handle()
    {
        $file = app(RetrieveExcelFiles::class)->handle();

        $pharmacies = app(ParsePharmacyListExcelFiles::class)->handle($file);

        $records = app(CreateOrUpdatePharmacy::class)->handle($pharmacies);

        return $records + [];
    }
}
