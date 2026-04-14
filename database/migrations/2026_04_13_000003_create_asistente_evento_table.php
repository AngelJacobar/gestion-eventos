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
        Schema::create('asistente_evento', function (Blueprint $table) {
            $table->comment('Registro de inscripciones de usuarios a eventos.');
            $table->id('id_asistente_evento')->comment('Identificador de la inscripción del asistente al evento, por ejemplo: 1');
            $table->bigInteger('id_usuario')->unsigned()->comment('Identificador del usuario que se inscribe al evento.');
            $table->bigInteger('id_evento')->unsigned()->comment('Identificador del evento al que se inscribe el usuario.');
            $table->date('fecha_registro')->comment('Fecha en que el usuario se inscribió al evento.');
            $table->char('asistencia', 1)->default('N')->comment('Indica si el usuario asistió al evento: S = Sí, N = No.');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->onDelete('cascade')->comment('Relación con la tabla usuario.');
            $table->foreign('id_evento')->references('id_evento')->on('evento')->onDelete('cascade')->comment('Relación con la tabla eventos.');
            $table->timestamp('created_at')->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
            
            // Evitar inscripciones duplicadas
            $table->unique(['id_usuario', 'id_evento'], 'unique_usuario_evento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistente_evento');
    }
};
