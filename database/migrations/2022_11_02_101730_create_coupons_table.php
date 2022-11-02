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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('isAvailable');
            $table->boolean('isAmount')->default(false);
            $table->integer('offerAmount')->nullable();
            $table->boolean('isPercent')->default(false);
            $table->integer('offerPercent')->nullable();
            $table->integer('maxDisAmount')->nullable();
            $table->integer('minAmount');
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
        Schema::dropIfExists('coupons');
    }
};
