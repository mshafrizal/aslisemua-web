<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image_path')->nullable();
            $table->string('image_name')->nullable();
            $table->string('alt_image')->nullable();
            $table->timestamps();
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->string('alt_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('alt_image');
        });
    }
}
