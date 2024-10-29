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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('primer_nombre', 255);
            $table->string('segundo_nombre', 255)->nullable();
            $table->string('primer_apellido', 255);
            $table->string('segundo_apellido', 255);
            $table->string('numero_inss', 255);
            $table->integer('antiguedad');
            $table->decimal('salario_bruto', 10, 2);
            $table->boolean('activo');
            $table->unsignedBigInteger('departamentocargo_id');
            $table->foreign('departamentocargo_id')->references('id')->on('departamentocargo')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
