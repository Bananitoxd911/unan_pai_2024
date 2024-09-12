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
        Schema::create('banco_balance_total', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empresa'); //para la relación con la empresa.
            $table->string('numero_de_cuenta')->unique();
            $table->decimal('balance', 10, 2)->default(5000.00); //Saldo en Fondo fijo.
            $table->decimal('balance_max',10,2)->default(0);//Para que se establezca el fondo fijo máximo.
            $table->timestamps();
            
            $table->foreign('id_empresa')->references('id')->on('empresas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banco_balance_total');
    }
};
