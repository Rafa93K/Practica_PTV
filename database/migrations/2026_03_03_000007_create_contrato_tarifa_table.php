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
        Schema::create('contrato_tarifa', function (Blueprint $table) {
            $table->foreignId('contrato_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tarifa_id')->constrained()->cascadeOnDelete();
            $table->date('fecha_inicio'); //Fecha de inicio
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrato_tarifa');
    }
};
