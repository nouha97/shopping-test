<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_cart', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->string('cart_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('cart_id')->references('identifier')->on('carts');
            $table->bigInteger('qty');
            $table->string('row_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_cart');
    }
}
