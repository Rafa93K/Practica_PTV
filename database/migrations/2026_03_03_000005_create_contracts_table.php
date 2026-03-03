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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();

            //Si el cliente se elimina, borra todos los contratos
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            
            //Si el trabajador se elimina, todos los contratos tienen de valor null
            $table->foreignId('worker_id')->nullable()->constrained()->nullOnDelete();

            $table->string('city');
            $table->string('province');
            $table->string('street');
            $table->unsignedInteger('number');
            $table->string('door')->nullable(); //Puede ser nulo en caso de ser una sola casa, no un piso
            $table->string('zip_code');
            $table->boolean('approved')->default(false); //Valor por defecto false
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
