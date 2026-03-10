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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();

            //Si el cliente se elimina, borra todos los contratos
            $table->foreignId('cliente_id')->constrained()->cascadeOnDelete();
            
            //Si el trabajador se elimina, todos los contratos tienen de valor null
            $table->foreignId('trabajadore_id')->nullable()->constrained()->nullOnDelete();

            $table->string('ciudad');
            $table->string('provincia');
            $table->string('calle');
            $table->unsignedInteger('numero');
            $table->string('puerta')->nullable(); //Puede ser nulo en caso de ser una sola casa, no un piso
            $table->string('codigo_postal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
