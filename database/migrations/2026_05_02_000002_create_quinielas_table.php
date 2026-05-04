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
        Schema::create('quinielas', function (Blueprint $table) {
            $table->comment('Registro de quinielas con pronósticos de los usuarios.');
            $table->id('id_quiniela')->comment('Identificador único de la quiniela.');
            $table->string('jornada', 50)->nullable()->comment('Nombre o número de la jornada asociada.');
            $table->string('nombre', 100)->comment('Nombre del participante.');
            $table->string('telefono', 20)->nullable()->comment('Teléfono de contacto del participante.');
            
            // Pronósticos para cada partido
            $table->char('pronostico_1', 1)->nullable()->comment('Pronóstico para el partido 1: L = Local, V = Visitante, E = Empate.');
            $table->char('pronostico_2', 1)->nullable()->comment('Pronóstico para el partido 2: L = Local, V = Visitante, E = Empate.');
            $table->char('pronostico_3', 1)->nullable()->comment('Pronóstico para el partido 3: L = Local, V = Visitante, E = Empate.');
            $table->char('pronostico_4', 1)->nullable()->comment('Pronóstico para el partido 4: L = Local, V = Visitante, E = Empate.');
            $table->char('pronostico_5', 1)->nullable()->comment('Pronóstico para el partido 5: L = Local, V = Visitante, E = Empate.');
            $table->char('pronostico_6', 1)->nullable()->comment('Pronóstico para el partido 6: L = Local, V = Visitante, E = Empate.');
            $table->char('pronostico_7', 1)->nullable()->comment('Pronóstico para el partido 7: L = Local, V = Visitante, E = Empate.');
            $table->char('pronostico_8', 1)->nullable()->comment('Pronóstico para el partido 8: L = Local, V = Visitante, E = Empate.');
            $table->char('pronostico_9', 1)->nullable()->comment('Pronóstico para el partido 9: L = Local, V = Visitante, E = Empate.');
            
            $table->integer('puntaje_total')->default(0)->comment('Puntaje total acumulado por los aciertos.');
            $table->char('estatus', 1)->nullable()->comment('Estatus de la quiniela: S = Activo, N = Inactivo, P = Pendiente.');
            $table->timestamp('fecha_registro')->useCurrent()->comment('Fecha y hora de registro de la quiniela.');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });
        
        // Agregar check constraints usando SQL raw para PostgreSQL
        DB::statement("ALTER TABLE quinielas ADD CONSTRAINT check_pronostico_1 CHECK (pronostico_1 IS NULL OR UPPER(pronostico_1) IN ('L', 'V', 'E'))");
        DB::statement("ALTER TABLE quinielas ADD CONSTRAINT check_pronostico_2 CHECK (pronostico_2 IS NULL OR UPPER(pronostico_2) IN ('L', 'V', 'E'))");
        DB::statement("ALTER TABLE quinielas ADD CONSTRAINT check_pronostico_3 CHECK (pronostico_3 IS NULL OR UPPER(pronostico_3) IN ('L', 'V', 'E'))");
        DB::statement("ALTER TABLE quinielas ADD CONSTRAINT check_pronostico_4 CHECK (pronostico_4 IS NULL OR UPPER(pronostico_4) IN ('L', 'V', 'E'))");
        DB::statement("ALTER TABLE quinielas ADD CONSTRAINT check_pronostico_5 CHECK (pronostico_5 IS NULL OR UPPER(pronostico_5) IN ('L', 'V', 'E'))");
        DB::statement("ALTER TABLE quinielas ADD CONSTRAINT check_pronostico_6 CHECK (pronostico_6 IS NULL OR UPPER(pronostico_6) IN ('L', 'V', 'E'))");
        DB::statement("ALTER TABLE quinielas ADD CONSTRAINT check_pronostico_7 CHECK (pronostico_7 IS NULL OR UPPER(pronostico_7) IN ('L', 'V', 'E'))");
        DB::statement("ALTER TABLE quinielas ADD CONSTRAINT check_pronostico_8 CHECK (pronostico_8 IS NULL OR UPPER(pronostico_8) IN ('L', 'V', 'E'))");
        DB::statement("ALTER TABLE quinielas ADD CONSTRAINT check_pronostico_9 CHECK (pronostico_9 IS NULL OR UPPER(pronostico_9) IN ('L', 'V', 'E'))");
        DB::statement("ALTER TABLE quinielas ADD CONSTRAINT check_estatus CHECK (estatus IS NULL OR UPPER(estatus) IN ('S', 'N', 'P'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quinielas');
    }
};
