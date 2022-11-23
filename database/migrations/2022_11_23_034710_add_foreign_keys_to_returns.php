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
        Schema::table('returns', function (Blueprint $table) {
            $table->foreign('products_id', 'fk_returns_to_products')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('suppliers_id', 'fk_returns_to_suppliers')->references('id')->on('suppliers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('returns', function (Blueprint $table) {
            $table->dropForeign('fk_returns_to_products');
            $table->dropForeign('fk_returns_to_suppliers');
        });
    }
};
