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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre del paciente
            $table->string('apellido'); // Apellido del paciente
            $table->string('nro_documento')->unique(); // Campo de nro_documento único, tamaño de un bigInteger
            $table->string('email')->nullable(); // Correo electrónico único
            $table->string('telefono')->nullable(); // Teléfono del paciente
            $table->string('obra_social')->nullable(); // Teléfono del paciente
            $table->boolean('estado')->default(true); // Estado del paciente, activo por defecto
            $table->timestamps();
        });

        // Migración para crear la tabla de turnos
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id')->nullable();
            $table->date('fecha');
            $table->time('hora');
            $table->string('estado')->default('libre');
            $table->text('motivo')->nullable();
            $table->timestamps();
            // Definición de la clave foránea
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
