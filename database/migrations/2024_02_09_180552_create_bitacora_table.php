<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bitacora', function (Blueprint $table) {
            $table->comment('Bitácora de las acciones realizadas por los usuarios en el sistema.');
            $table->id('id_bitacora')->comment('Identificador del registro en la bitácora, por ejemplo: 1');
            $table->bigInteger('id_accion')->unsigned()->comment('Identificador de la acción realizada en el sistema, por ejemplo: 10.');
            $table->bigInteger('id_usuario')->unsigned()->comment('');
            $table->string('descripcion')->nullable()->comment('Descripción de la acción realizada en el sistema, por ejemplo: iniciar sesión.');
            $table->dateTime('fecha_hora')->useCurrent()->comment('Fecha y hora del registro de la acción en la bitácora.');
            $table->string('registro_tipo')->nullable()->comment('Tipo de registro, por ejemplo: registro asunto.');
            $table->string('registro_id')->nullable()->comment('Identificador del tipo de registro: por ejemplo: 25.');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->comment('Identificador del usuario.');
            $table->foreign('id_accion')->references('id_accion')->on('accion');
            $table->timestamp('created_at')->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora');
    }
};
