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
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['region_id']);
            $table->dropForeign(['delivery_fee_id']);

            // Update region_id to be unsignedBigInteger and nullable
            $table->unsignedBigInteger('region_id')->nullable()->change();

            // Update delivery_fee_id to be unsignedBigInteger and nullable
            $table->unsignedBigInteger('delivery_fee_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
