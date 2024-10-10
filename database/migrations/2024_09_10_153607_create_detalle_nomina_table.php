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
        Schema::create('detalle_nomina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_nomina')->constrained('nominas')->onDelete('cascade');
            $table->foreignId('id_empleado')->constrained('empleados')->onDelete('cascade');
            $table->decimal('salario_bruto', 10, 2);
            $table->integer('cantidad_hrs_extra');
            $table->decimal('ir', 8, 2);
            $table->decimal('antiguedad_porcentaje', 10, 2);
            $table->decimal('antiguedad_monto', 10, 2);
            $table->decimal('inss_patronal', 10, 2);
            $table->decimal('vacaciones', 10, 2);
            $table->decimal('treceavo_mes', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_nomina');
    }
};
