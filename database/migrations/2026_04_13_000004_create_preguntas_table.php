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
        Schema::create('pregunta', function (Blueprint $table) {
            $table->comment('Catálogo de preguntas para la encuesta de satisfacción.');
            $table->id('id_pregunta')->comment('Identificador de la pregunta, por ejemplo: 1');
            $table->string('pregunta', 100)->comment('Texto de la pregunta, por ejemplo: ¿Cómo califica el evento?');
            $table->char('activa', 1)->default('S')->comment('Indica si la pregunta está activa: S = Sí, N = No.');
            $table->timestamp('created_at')->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregunta');
    }
};
