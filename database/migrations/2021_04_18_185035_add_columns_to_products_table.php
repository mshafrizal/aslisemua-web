<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('size')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('color')->nullable()->change();
            $table->string('description')->nullable()->change();
            $table->string('detail')->nullable()->change();
            $table->integer('discount_price')->nullable()->change();
            $table->string('alt_image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
