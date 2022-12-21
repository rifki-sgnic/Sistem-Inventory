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
        Schema::create('request_product_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_products_id')->index('fk_request_product_detail_to_request_products');
            $table->foreignId('products_id')->index('fk_request_product_detail_to_products');
            $table->integer('qty');
            $table->integer('harga');
            $table->string('remarks');
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
        Schema::dropIfExists('request_product_detail');
    }
};
