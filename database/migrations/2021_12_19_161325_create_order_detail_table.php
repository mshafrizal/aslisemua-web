<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_id');
            $table->uuid('product_id');
            $table->string('product_name');
            $table->string('size');
            $table->string('gender');
            $table->string('color');
            $table->uuid('brand_id');
            $table->string('brand_name');
            $table->uuid('category_id');
            $table->string('category_name');
            $table->float('base_price');
            $table->float('discount_price');
            $table->float('final_price');
            $table->string('image_path');
            $table->string('image_name');
            $table->string('alt_image');
            $table->timestamps();
        });

        Schema::table('order_details', function (Blueprint $table) {
            $table->foreign('order_id')->references('order_id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
