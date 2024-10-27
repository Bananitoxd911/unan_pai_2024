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
        Schema::create('nomina_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nomina_id');
            $table->unsignedBigInteger('detalle_id');
            $table->foreign('nomina_id')->references('id')->on('nomina')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('detalle_id')->references('id')->on('detalle_nomina')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomina_detalle');
    }
};
