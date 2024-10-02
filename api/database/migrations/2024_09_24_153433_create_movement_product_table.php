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
        Schema::create('movement_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movements_id');
            $table->unsignedBigInteger('produtos_id');
            $table->timestamps();
            $table->foreign('movements_id')->references('id')->on('movements')->onDelete('cascade');
            $table->foreign('produtos_id')->references('id')->on('produtos')->onDelete('cascade');
            $table->integer('quantidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_product');
    }
};
