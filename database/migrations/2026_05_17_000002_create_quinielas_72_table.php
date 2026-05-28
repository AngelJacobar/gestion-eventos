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
        Schema::create('quinielas_72', function (Blueprint $table) {
            $table->comment('Registro de quinielas de 72 partidos con pronósticos de los usuarios.');
            $table->id('id_quiniela_72')->comment('Identificador único de la quiniela de 72 partidos.');
            $table->string('jornada', 50)->nullable()->comment('Nombre o número de la jornada asociada.');
            $table->string('nombre', 100)->comment('Nombre del participante.');
            $table->string('telefono', 20)->nullable()->comment('Teléfono de contacto del participante.');
            $table->integer('puntaje_total')->default(0)->comment('Puntaje total acumulado por los aciertos.');
            $table->char('estatus', 1)->nullable()->comment('Estatus de la quiniela: S = Activo, N = Inactivo, P = Pendiente.');
            $table->timestamp('fecha_registro')->useCurrent()->comment('Fecha y hora de registro de la quiniela.');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });
        
        // Agregar check constraint usando SQL raw para PostgreSQL
        DB::statement("ALTER TABLE quinielas_72 ADD CONSTRAINT check_estatus_72 CHECK (estatus IS NULL OR UPPER(estatus) IN ('S', 'N', 'P'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quinielas_72');
    }
};
