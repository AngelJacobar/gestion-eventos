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
        Schema::create('evento', function (Blueprint $table) {
            $table->comment('Catálogo de eventos organizados en el sistema.');
            $table->id('id_evento')->comment('Identificador del evento, por ejemplo: 1');
            $table->string('nombre', 100)->comment('Nombre del evento, por ejemplo: Conferencia de Tecnología 2026.');
            $table->date('fecha_inicio')->comment('Fecha de inicio del evento.');
            $table->date('fecha_fin')->comment('Fecha de finalización del evento.');
            $table->string('lugar', 255)->comment('Lugar donde se realizará el evento, por ejemplo: Auditorio Principal.');
            $table->integer('capacidad')->comment('Capacidad máxima de asistentes al evento, por ejemplo: 500.');
            $table->char('activo', 1)->default('S')->comment('Indica si el evento está activo: S = Sí, N = No.');
            $table->timestamp('created_at')->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento');
    }
};
