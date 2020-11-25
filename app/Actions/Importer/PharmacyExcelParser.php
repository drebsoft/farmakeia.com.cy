<?php


namespace App\Actions\Importer;

use App\Models\Availability;
use App\Models\Pharmacy;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class PharmacyExcelParser implements WithHeadingRow, OnEachRow
{
    use Importable;

    public function onRow(Row $row)
    {
        /** @var Pharmacy $pharmacy */
        $pharmacy = Pharmacy::firstOrCreate([
            'am' => $row['am'],
        ], [
            'name'       => "{$row['onoma']} {$row['epitheto']}",
            'address'    => $row['dieuthinsi'],
            'address2'   => $row['simpliromatiki_dieuthinsi'],
            'area'       => $row['dimos_koinotita'],
            'phone'      => $row['tilefono_farmakioy'],
            'home_phone' => $row['tilefono_oikias'],
        ]);

        // This works!
        Availability::insertOrIgnore([
            'pharmacy_id' => $pharmacy->id,
            'date'        => Carbon::createFromFormat('d/m/y', $row['hmerominia']),
        ]);

        // This doesn't
        // $pharmacy->availabilities()->insertOrIgnore([
        //     'date' => Carbon::createFromFormat('d/m/y', $row['hmerominia']),
        // ]);
    }
}
