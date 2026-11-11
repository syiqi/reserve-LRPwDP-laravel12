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
        Schema::create('perishables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sellerID')->unsigned();
            $table->foreign('sellerID')->references('id')->on('users')->cascadeOnDelete();
            $table->string('name');
            $table->integer('quantity');
            $table->integer('quantityOriginal');
            $table->double('priceOriginal');
            $table->double('priceCurrent');
            $table->double('priceLowerBound');
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            $table->boolean('halal');
            $table->dateTime('expiryDate');
            $table->boolean('status');
            $table->string('measurement')->nullable();
            $table->string('imagePath')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perishables');
    }
};
