<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('perishableID')->unsigned()->nullable();
            $table->foreign('perishableID')->references('id')->on('perishables')->nullOnDelete();
            
            $table->bigInteger('customerID')->unsigned()->nullable();
            $table->foreign('customerID')->references('id')->on('users')->nullOnDelete();
            $table->string('reserveName');
            $table->integer('reserveQuantity');
            $table->double('reservePrice');
            $table->datetime('pickupTime');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
