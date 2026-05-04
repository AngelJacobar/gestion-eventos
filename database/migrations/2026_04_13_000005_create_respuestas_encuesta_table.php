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
        Schema::create('respuesta_encuesta', function (Blueprint $table) {
            $table->comment('Registro de respuestas a las encuestas de satisfacción por evento.');
            $table->id('id_respuesta_encuesta')->comment('Identificador de la respuesta de la encuesta, por ejemplo: 1');
            $table->bigInteger('id_asistente_evento')->unsigned()->comment('Identificador de la inscripción del asistente al evento.');
            $table->bigInteger('id_pregunta')->unsigned()->comment('Identificador de la pregunta respondida.');
            $table->string('respuesta', 100)->comment('Respuesta proporcionada por el asistente.');
            $table->foreign('id_asistente_evento')->references('id_asistente_evento')->on('asistente_evento')->onDelete('cascade')->comment('Relación con la tabla asistente_evento.');
            $table->foreign('id_pregunta')->references('id_pregunta')->on('pregunta')->onDelete('cascade')->comment('Relación con la tabla pregunta.');
            $table->timestamp('created_at')->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuesta_encuesta');
    }
};
