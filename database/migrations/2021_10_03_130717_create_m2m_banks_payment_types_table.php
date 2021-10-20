<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateM2mBanksPaymentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_types_banks', function (Blueprint $table) {
            $table->uuid('bank_id');
            $table->uuid('payment_type_id');
            $table->timestamps();
        });

        Schema::table('payment_types_banks', function (Blueprint $table) {
            $table->foreign('bank_id')->references('id')->on('banks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_types_banks');
    }
}
