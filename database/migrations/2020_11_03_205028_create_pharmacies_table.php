<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('area')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('address');
            $table->string('address2')->nullable();
            $table->integer('phone')->nullable();
            $table->integer('home_phone')->nullable();
            $table->unsignedInteger('am')->nullable()->unique();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacies');
    }
}
