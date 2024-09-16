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
        Schema::create('caja_general_total', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empresa'); //para la relación con la empresa.
            $table->decimal('fondos', 10, 2); //Saldo en Fondo fijo.
            $table->timestamps();
            
            $table->foreign('id_empresa')->references('id')->on('empresas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_general_total');
    }
};
