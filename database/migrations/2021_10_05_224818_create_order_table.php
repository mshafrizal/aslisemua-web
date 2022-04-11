<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_id')->unique();
            $table->string('billing_name');
            $table->string('billing_email');
            $table->string('billing_phone_number');
            $table->string('billing_zip_code');
            $table->text('billing_address');
            $table->string('billing_city');
            $table->string('billing_district');
            $table->string('shipping_name');
            $table->string('shipping_phone_number');
            $table->string('shipping_zip_code');
            $table->text('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_district');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->string('canceled_by');
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->string('delivered_by');
            $table->timestamp('finished_at')->nullable();
            $table->string('finished_by');
            $table->string('note')->nullable();
            $table->string('payment_type');
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('order_status');
            $table->string('shipping_status');
            $table->timestamp('delivery_at')->nullable();
            $table->string('delivery_by');
            $table->timestamp('paid_at')->nullable();
            $table->string('paid_by');
            $table->string('processed_by');
            $table->enum('is_installment', [true, false]);
            $table->float('total_base_price');
            $table->float('discount_price');
            $table->float('total_final_price');
            $table->float('handling_fee')->nullable();
            $table->string('total_installment')->nullable();
            $table->timestamp('pending_at')->nullable();
            $table->timestamp('processed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
