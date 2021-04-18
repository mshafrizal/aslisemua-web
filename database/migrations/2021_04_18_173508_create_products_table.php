<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('size');
            $table->string('gender');
            $table->string('color');
            $table->uuid('brand_id');
            $table->uuid('category_id');
            $table->string('condition');
            $table->text('description');
            $table->text('detail');
            $table->integer('base_price');
            $table->integer('discount_price');
            $table->integer('final_price');
            $table->string('image_path');
            $table->string('image_name');
            $table->string('alt_image');
            $table->boolean('status');
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
