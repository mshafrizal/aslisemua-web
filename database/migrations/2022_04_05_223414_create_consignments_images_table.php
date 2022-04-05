<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsignmentsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignments_images', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('consignment_id');
            $table->string('image_path');
            $table->string('image_name');
            $table->string('file_id');
            $table->string('filename');
            $table->timestamps();
        });

        Schema::table('consignments_images', function (Blueprint $table) {
            $table->foreign('consignment_id')->references('id')->on('consignments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consignments_images');
    }
}
