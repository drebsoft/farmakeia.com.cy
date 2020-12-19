<?php

use App\Models\Pharmacy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToPharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        foreach (Pharmacy::cursor() as $pharmacy) {
            /** @var Pharmacy $pharmacy */
            $pharmacy->generateSlug();
            $pharmacy->save();
        }

        Schema::table('pharmacies', function (Blueprint $table) {
            $table->string('slug')->after('name')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
