<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quinielas_detalle_72', function (Blueprint $table) {
            $table->comment('Detalle de pronósticos para cada partido de una quiniela de 72.');
            $table->id('id_detalle_72')->comment('Identificador único del detalle.');
            $table->unsignedBigInteger('id_quiniela_72')->comment('Referencia a la quiniela de 72 partidos.');
            $table->unsignedBigInteger('id_partido_72')->comment('Referencia al partido de 72.');
            $table->char('pronostico', 1)->nullable()->comment('Pronóstico del usuario: L = Local, V = Visitante, E = Empate.');
            $table->boolean('acierto')->nullable()->default(null)->comment('Indica si el pronóstico fue correcto: true = acierto, false = fallo, null = sin calificar.');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
            
            // Foreign keys
            $table->foreign('id_quiniela_72')->references('id_quiniela_72')->on('quinielas_72')->onDelete('cascade');
            $table->foreign('id_partido_72')->references('id_partido_72')->on('partidos_72')->onDelete('cascade');
            
            // Índices para mejorar rendimiento
            $table->index('id_quiniela_72');
            $table->index('id_partido_72');
            $table->unique(['id_quiniela_72', 'id_partido_72'], 'unique_quiniela_partido_72');
        });
        
        // Agregar check constraint usando SQL raw para PostgreSQL
        DB::statement("ALTER TABLE quinielas_detalle_72 ADD CONSTRAINT check_pronostico_72 CHECK (pronostico IS NULL OR UPPER(pronostico) IN ('L', 'V', 'E'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quinielas_detalle_72');
    }
};
