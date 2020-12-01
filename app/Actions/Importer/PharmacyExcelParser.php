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

    private $city;
    private $rowCount;
    private $addedCount;
    private $updatedCount;
    private $alreadyFineCount;
    private $failedCount;

    public function __construct(string $city)
    {
        $this->city = $city;
        $this->rowCount = 0;
        $this->addedCount = 0;
        $this->updatedCount = 0;
        $this->alreadyFineCount = 0;
        $this->failedCount = 0;
    }

    public function onRow($row)
    {
        $this->rowCount++;

        if (empty(trim($row['am']))) {
            $this->failedCount++;
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

        if ($pharmacy->wasRecentlyCreated) {
            $this->addedCount++;
        }

        if (!$pharmacy->wasRecentlyCreated) {
            $pharmacy->wasChanged() ? $this->updatedCount++ : $this->alreadyFineCount++;
        }

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

    public function getCounts()
    {
        return [
            'rows' => $this->rowCount,
            'added' => $this->addedCount,
            'updated' => $this->updatedCount,
            'alreadyFine' => $this->alreadyFineCount,
            'failed' => $this->failedCount,
        ];
    }
}
