<?php

namespace App\Actions\Importer;

use App\Models\Availability;
use App\Models\Pharmacy;
use App\Services\Helpers;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class PharmacyExcelParser implements OnEachRow, WithHeadingRow, WithProgressBar
{
    use Importable;

    private $city;
    private $rowCount;
    private $failedCount;
    private $pharmacyCounts;
    private $touchedIds;
    private $availabilityCounts;

    public function __construct(string $city)
    {
        $this->city = $city;
        $this->rowCount = 0;
        $this->failedCount = 0;
        $this->pharmacyCounts = [
            'added' => 0,
            'updated' => 0,
            'alreadyFine' => 0,
        ];
        $this->touchedIds = [];
        $this->availabilityCounts = [
            'added' => 0,
            'updated' => 0,
            'alreadyFine' => 0,
        ];
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
            'name' => "{$row['onoma']} {$row['epitheto']}",
            'region' => $this->city,
            'address' => $row['dieuthinsi'],
            'additional_address' => $this->checkForZero($row['simpliromatiki_dieuthinsi']),
            'area' => $this->checkForZero($row['dimos_koinotita'] ?? null),
            'phone' => $this->checkForZero($row['tilefono_farmakioy']),
            'home_phone' => $this->checkForZero($row['tilefono_oikias'] ?? null),
            'map_address' => Helpers::generateMapAddress($row['dieuthinsi'], $this->checkForZero($row['dimos_koinotita'] ?? null), $this->city),
        ]);

        if (!in_array($pharmacy->id, $this->touchedIds)) {
            if ($pharmacy->wasRecentlyCreated) {
                $this->pharmacyCounts['added']++;
            }

            if (!$pharmacy->wasRecentlyCreated) {
                $pharmacy->wasChanged()
                    ? $this->pharmacyCounts['updated']++
                    : $this->pharmacyCounts['alreadyFine']++;
            }

            $this->touchedIds[] = $pharmacy->id;
        }

        $availability = Availability::updateOrCreate([
            'pharmacy_id' => $pharmacy->id,
            'date' => Carbon::createFromFormat('d/m/y', $row['hmerominia'])->format('Y-m-d'),
        ]);

        if ($availability->wasRecentlyCreated) {
            $this->availabilityCounts['added']++;
        }

        if (!$availability->wasRecentlyCreated) {
            $availability->wasChanged()
                ? $this->availabilityCounts['updated']++
                : $this->availabilityCounts['alreadyFine']++;
        }
    }

    public function checkForZero($value)
    {
        return $value === 0 ? null : $value;
    }

    public function getCounts()
    {
        return [
            'rows' => $this->rowCount,
            'pharmacies' => $this->pharmacyCounts,
            'availabilities' => $this->availabilityCounts,
            'failed' => $this->failedCount,
        ];
    }
}
