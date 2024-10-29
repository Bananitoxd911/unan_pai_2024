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
            $table->unsignedBigInteger('empresaempleado_id');
            $table->integer('cantidad_hrs_extras');
            $table->decimal('monto_hrs_extra', 8, 2);
            $table->decimal('antiguedad_porcentaje', 8, 2);
            $table->decimal('total_ingreso', 8, 2);
            $table->decimal('inss_laboral', 8, 2);
            $table->decimal('ir', 8, 2);
            $table->decimal('total_deducciones', 8, 2);
            $table->decimal('neto_recibir', 8, 2);
            $table->decimal('inss_patronal', 8, 2);
            $table->decimal('inatec', 8, 2);
            $table->decimal('vacaciones', 8, 2);
            $table->decimal('treceavomes', 8, 2);
            $table->foreign('empresaempleado_id')->references('id')->on('empresa_empleado')->onDelete('cascade')->onUpdate('cascade');
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
