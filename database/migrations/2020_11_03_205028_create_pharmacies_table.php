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
            $table->string('region');
            $table->string('area')->nullable();
            $table->string('address');
            $table->string('additional_address')->nullable();
            $table->integer('phone')->nullable();
            $table->integer('home_phone')->nullable();
            $table->unsignedInteger('am')->nullable()->unique();
            $table->foreignId('owner_id')->nullable()->constrained('users');
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();

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
