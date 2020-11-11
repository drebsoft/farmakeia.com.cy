<?php namespace App\Actions\Importer;


class UpdatePharmacies
{
    public function handle()
    {
        $files = app(RetrieveExcelFiles::class)->handle();

        dd($files);
        $pharmacies = app(ParsePharmacyListExcelFiles::class)->handle($files);

        dd($pharmacies);
        $records = app(CreateOrUpdatePharmacy::class)->handle($pharmacies);

        return $records + [];
    }
}
