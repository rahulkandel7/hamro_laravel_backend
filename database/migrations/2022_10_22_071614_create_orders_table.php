<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignId('user_id')->constrained();
            $table->foreignId('shipping_id')->constrained();
            $table->string('coupon_id')->nullable();
            $table->string('cart_id');
            $table->integer('coupon_amount')->default(0);
            $table->integer('delivery_charge');
            $table->string('shipping_address');
            $table->string('fullname');
            $table->string('phone');
            $table->string('payment')->default('COD');
            $table->string('status')->default('Pending');
            $table->string('cancel_reason')->nullable();
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
};
