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
        Schema::create('partidos_semana', function (Blueprint $table) {
            $table->comment('Catálogo de partidos programados por jornada.');
            $table->id('id_partido')->comment('Identificador único del partido.');
            $table->string('jornada', 50)->nullable()->comment('Nombre o número de la jornada, por ejemplo: Jornada 1.');
            $table->integer('numero_partido')->nullable()->comment('Número del partido dentro de la jornada, por ejemplo: 1, 2, 3, etc.');
            $table->string('equipo_local', 100)->comment('Nombre del equipo local.');
            $table->string('equipo_visitante', 100)->comment('Nombre del equipo visitante.');
            $table->timestamp('fecha_partido')->nullable()->comment('Fecha y hora del partido.');
            $table->char('resultado', 1)->nullable()->comment('Resultado del partido: L = Local, V = Visitante, E = Empate.');
            $table->char('estatus', 1)->nullable()->comment('Estatus del partido: S = Activo, N = Inactivo, P = Pendiente.');
            $table->timestamp('fecha_inicio_jornada')->nullable()->comment('Fecha de inicio de la jornada.');
            $table->timestamp('fecha_fin_jornada')->nullable()->comment('Fecha de finalización de la jornada.');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });
        
        // Agregar check constraint usando SQL raw para PostgreSQL
        DB::statement("ALTER TABLE partidos_semana ADD CONSTRAINT check_resultado CHECK (resultado IS NULL OR UPPER(resultado) IN ('L', 'V', 'E'))");
        DB::statement("ALTER TABLE partidos_semana ADD CONSTRAINT check_estatus CHECK (estatus IS NULL OR UPPER(estatus) IN ('S', 'N', 'P'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidos_semana');
    }
};
