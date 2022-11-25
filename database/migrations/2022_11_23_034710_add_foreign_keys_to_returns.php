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
        Schema::table('return_products', function (Blueprint $table) {
            $table->foreign('products_id', 'fk_return_products_to_products')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('suppliers_id', 'fk_return_products_to_suppliers')->references('id')->on('suppliers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('list_products_id', 'fk_return_products_to_list_products')->references('id')->on('list_products')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('return_products', function (Blueprint $table) {
            $table->dropForeign('fk_return_products_to_products');
            $table->dropForeign('fk_return_products_to_list_products');
        });
    }
};
