<?php

namespace App\Actions\Importer;

use App\Models\Availability;
use App\Models\Pharmacy;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PharmacyExcelParser implements OnEachRow, WithHeadingRow
{
    use Importable;

    public function __construct(string $city)
    {
        $this->city = $city;
    }

    public function onRow($row)
    {
        if (empty(trim($row['am']))) {
            return;
        }

        /** @var Pharmacy $pharmacy */
        $pharmacy = Pharmacy::updateOrCreate([
            'am' => $row['am'],
        ], [
            'name'               => "{$row['onoma']} {$row['epitheto']}",
            'region'             => $this->city,
            'address'            => $row['dieuthinsi'],
            'additional_address' => $this->checkForZero($row['simpliromatiki_dieuthinsi']),
            'area'               => $this->checkForZero($row['dimos_koinotita'] ?? null),
            'phone'              => $this->checkForZero($row['tilefono_farmakioy']),
            'home_phone'         => $this->checkForZero($row['tilefono_oikias'] ?? null),
        ]);

        // This works!
        Availability::insertOrIgnore([
            'pharmacy_id' => $pharmacy->id,
            'date' => Carbon::createFromFormat('d/m/y', $row['hmerominia']),
        ]);

        // This doesn't
        // $pharmacy->availabilities()->insertOrIgnore([
        //     'date' => Carbon::createFromFormat('d/m/y', $row['hmerominia']),
        // ]);
    }

    public function checkForZero($value)
    {
        return $value === 0 ? null : $value;
    }
}
