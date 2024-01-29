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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->string('payment_photo')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('region_id')->constrained()->onDelete('cascade');
            $table->foreignId('delivery_fee_id')->constrained()->onDelete('cascade');
            $table->string('delivery_fee')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('start_date')->nullable();
            $table->string('overdue_date')->nullable();
            $table->string('return_date')->nullable();
            $table->string('status')->default('pending');
            $table->string('state')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
