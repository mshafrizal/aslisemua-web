<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->mediumText('notes')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('cta_name')->nullable();
            $table->string('cta_url')->nullable();
            $table->string('background')->nullable();
            $table->string('status')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('section')->nullable();
            $table->string('position')->nullable();
            $table->string('play_speed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
