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
        Schema::create('movimientos_caja_chica', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caja_chica_id');
            $table->unsignedBigInteger('movimiento_id');
            $table->foreign('caja_chica_id')->references('id')->on('caja_chica')->onDelete('cascade');
            $table->foreign('movimiento_id')->references('id')->on('movimientos')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_caja_chica');
    }
};
