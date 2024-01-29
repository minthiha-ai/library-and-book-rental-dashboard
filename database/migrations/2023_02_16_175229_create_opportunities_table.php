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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->enum('member_type',['0','1','2','3']);
            $table->integer('no_of_book');
            $table->integer('life_time');
            $table->integer('overdue_price_per_day');
            $table->integer('overdue_price_per_week');
            $table->integer('overdue_price_per_month');
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
        Schema::dropIfExists('opportunity');
    }
};
