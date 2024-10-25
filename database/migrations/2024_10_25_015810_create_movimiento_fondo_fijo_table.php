<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('movimientos_fondo_fijo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fondo_fijo_id');
            $table->unsignedBigInteger('movimiento_id');
            $table->foreign('fondo_fijo_id')->references('id')->on('fondo_fijo')->onDelete('cascade');
            $table->foreign('movimiento_id')->references('id')->on('movimientos')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_fondo_fijo');
    }
};
