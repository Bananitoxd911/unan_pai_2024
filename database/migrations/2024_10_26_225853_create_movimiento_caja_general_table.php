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
        Schema::create('movimiento_caja_general', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caja_general_id');
            $table->unsignedBigInteger('movimiento_id');
            $table->foreign('caja_general_id')->references('id')->on('caja_general')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('movimiento_id')->references('id')->on('movimientos')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_caja_general');
    }
};
