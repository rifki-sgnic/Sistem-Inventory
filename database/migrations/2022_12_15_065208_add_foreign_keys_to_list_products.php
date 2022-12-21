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
        Schema::table('list_products', function (Blueprint $table) {
            $table->foreign('request_products_id', 'fk_list_products_to_request_products')->references('id')->on('request_products')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('list_products', function (Blueprint $table) {
            $table->dropForeign('fk_list_products_to_request_products');
        });
    }
};
