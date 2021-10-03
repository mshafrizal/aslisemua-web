<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image_path')->nullable();
            $table->string('image_name')->nullable();
            $table->string('alt_image')->nullable();
            $table->string('key_name')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        // Schema::table('banners', function (Blueprint $table) {
        //     $table->string('alt_image')->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
        // Schema::table('banners', function (Blueprint $table) {
        //     $table->dropColumn('alt_image');
        // });
    }
}
