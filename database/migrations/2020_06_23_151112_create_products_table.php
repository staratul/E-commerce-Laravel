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
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('tags');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('title');
            $table->string('sub_title');
            $table->string('states');
            $table->string('colors');
            $table->string('size');
            $table->double('original_price');
            $table->integer('discount');
            $table->double('selling_price');
            $table->double('free_delivery_price');
            $table->double('weight')->nullable();
            $table->string('brand')->nullable();
            $table->string('seller_name');
            $table->unsignedBigInteger('seller_state')->nullable();
            $table->integer('total_in_stock');
            $table->string('pay_on_delivery')->nullable();
            $table->string('status');
            $table->text('product_details')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
