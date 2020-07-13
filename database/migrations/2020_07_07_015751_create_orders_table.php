<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('user_detail_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->string('product_qty');
            $table->double('product_price');
            $table->timestamp('checkout_date');
            $table->string('ip_address');
            $table->string('is_pay');
            $table->string('payment_type_id')->nullable();
            $table->string('product_color');
            $table->string('product_size');
            $table->string('is_confirm');
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
        Schema::dropIfExists('orders');
    }
}
