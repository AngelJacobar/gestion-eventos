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
        Schema::create('constancia', function (Blueprint $table) {
            $table->comment('Registro de constancias generadas para los asistentes a eventos.');
            $table->id('id_constancia')->comment('Identificador de la constancia, por ejemplo: 1');
            $table->bigInteger('id_asistente_evento')->unsigned()->comment('Identificador de la inscripción del asistente al evento.');
            $table->string('folio', 18)->unique()->comment('Folio único de la constancia, por ejemplo: CONST-2026-000001.');
            $table->timestamp('fecha_generacion')->useCurrent()->comment('Fecha y hora en que se generó la constancia.');
            $table->foreign('id_asistente_evento')->references('id_asistente_evento')->on('asistente_evento')->onDelete('cascade')->comment('Relación con la tabla asistente_evento.');
            $table->timestamp('created_at')->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constancia');
    }
};
