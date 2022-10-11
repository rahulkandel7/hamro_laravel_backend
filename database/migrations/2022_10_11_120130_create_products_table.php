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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('brand_id')->nullable()->constrained();
            $table->foreignId('subcategory_id')->nullable()->constrained();
            $table->longText('description');
            $table->integer('price');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('photopath1');
            $table->string('photopath2')->nullable();
            $table->string('photopath3')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('stock')->default(0);
            $table->integer('discountedprice')->nullable();
            $table->boolean('flashsale')->default(false);
            $table->boolean('deleted')->default(false);
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
        Schema::dropIfExists('products');
    }
};
