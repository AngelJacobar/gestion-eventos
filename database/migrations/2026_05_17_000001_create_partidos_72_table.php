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
        Schema::create('partidos_72', function (Blueprint $table) {
            $table->comment('Catálogo de 72 partidos programados para quinielas grandes.');
            $table->id('id_partido_72')->comment('Identificador único del partido.');
            $table->integer('numero_partido')->nullable()->comment('Número del partido, del 1 al 72.');
            $table->string('equipo_local', 100)->comment('Nombre del equipo local.');
            $table->string('equipo_visitante', 100)->comment('Nombre del equipo visitante.');
            $table->char('resultado', 1)->nullable()->comment('Resultado del partido: L = Local, V = Visitante, E = Empate.');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });
        
        // Agregar check constraint usando SQL raw para PostgreSQL
        DB::statement("ALTER TABLE partidos_72 ADD CONSTRAINT check_resultado_72 CHECK (resultado IS NULL OR UPPER(resultado) IN ('L', 'V', 'E'));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidos_72');
    }
};
