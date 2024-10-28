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
        // Schema::create('turnos', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('paciente_id'); // Debe coincidir con pacientes.id
        //     $table->date('fecha');
            
       
        //     $table->time('hora');
        //     $table->string('estado')->default('pendiente');
        //     $table->timestamps();

        //     // Define la clave foránea
            
          
        //     $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};
