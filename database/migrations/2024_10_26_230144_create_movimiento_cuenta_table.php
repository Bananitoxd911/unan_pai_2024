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
        Schema::create('movimiento_cuenta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cuenta_id');
            $table->unsignedBigInteger('movimiento_id');
            $table->foreign('cuenta_id')->references('id')->on('cuentas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('movimiento_id')->references('id')->on('movimientos')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_cuenta');
    }
};
