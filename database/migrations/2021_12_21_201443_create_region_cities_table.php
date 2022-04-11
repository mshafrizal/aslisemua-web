<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_cities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('province_id');
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::table('region_cities', function (Blueprint $table) {
          $table->foreign('province_id')->references('id')->on('region_provinces');
        });

        Schema::table("region_cities", function ($table) {
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
        Schema::table("region_cities", function ($table) {
          $table->dropSoftDeletes();
        });
        Schema::dropIfExists('region_cities');
    }
}
