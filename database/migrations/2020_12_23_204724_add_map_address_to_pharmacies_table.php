<?php

use App\Models\Pharmacy;
use App\Services\Helpers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMapAddressToPharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->text('map_address')->nullable()->after('additional_address');
        });

        foreach (Pharmacy::cursor() as $pharmacy) {
            $pharmacy->update([
                'map_address' => Helpers::generateMapAddress($pharmacy->address, $pharmacy->area, $pharmacy->region)
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->dropColumn('map_address');
        });
    }
}
