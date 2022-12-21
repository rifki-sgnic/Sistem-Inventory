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
        Schema::table('request_product_detail', function (Blueprint $table) {
            $table->foreign('request_products_id', 'fk_request_product_detail_to_request_products')->references('id')->on('request_products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('products_id', 'fk_request_product_detail_to_products')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_product_detail', function (Blueprint $table) {
            $table->dropForeign('fk_request_product_detail_to_request_products');
            $table->dropForeign('fk_request_product_detail_to_products');
        });
    }
};
