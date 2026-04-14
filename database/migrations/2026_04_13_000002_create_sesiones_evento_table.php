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
        Schema::create('sesion_evento', function (Blueprint $table) {
            $table->comment('Registro de sesiones programadas para cada evento.');
            $table->id('id_sesion')->comment('Identificador de la sesión del evento, por ejemplo: 1');
            $table->bigInteger('id_evento')->unsigned()->comment('Identificador del evento al que pertenece la sesión.');
            $table->date('fecha')->comment('Fecha en que se llevará a cabo la sesión.');
            $table->time('hora_inicio')->comment('Hora de inicio de la sesión, por ejemplo: 10:00.');
            $table->time('hora_fin')->comment('Hora de finalización de la sesión, por ejemplo: 12:00.');
            $table->string('ponente', 100)->comment('Nombre del ponente de la sesión, por ejemplo: Dr. Juan Pérez.');
            $table->foreign('id_evento')->references('id_evento')->on('evento')->onDelete('cascade')->comment('Relación con la tabla eventos.');
            $table->timestamp('created_at')->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesion_evento');
    }
};
