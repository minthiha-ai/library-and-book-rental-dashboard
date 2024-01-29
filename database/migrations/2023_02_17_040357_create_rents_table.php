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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->integer('book_id');
            $table->integer('user_id');
            $table->enum('status',['0','1'])->default('1');
            $table->string('start_date');
            $table->string('overdue_date');
            $table->string('overdue_day');
            $table->integer('unit_price');
            $table->string('return_date')->nullable();
            $table->enum('state',['0','1','2'])->default('0');
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
        Schema::dropIfExists('rents');
    }
};
