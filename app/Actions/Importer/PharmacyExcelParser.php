<?php


namespace App\Actions\Importer;

use App\Models\Pharmacy;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;

class PharmacyExcelParser implements ToModel, WithChunkReading, WithHeadingRow, WithPreCalculateFormulas
{
    public function model(array $row)
    {
        dd($row);
        return new Pharmacy([
            'name' => $row[0],
        ]);
    }

    public function chunkSize() : int
    {
        return 100;
    }
}
