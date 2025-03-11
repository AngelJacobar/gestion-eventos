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
        Schema::create('accion', function (Blueprint $table) {
            $table->comment('Catálogo de acciones realizadas por un usuario en el sistema.');
            $table->id('id_accion')->comment('Identificador de la acción realizada por un usuario en el sistema, por ejemplo: 7.');
            $table->string('nombre')->comment('Nombre de la acción que se almacenará en la bitácora.');
            $table->timestamp('created_at')->default('now()')->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accion');
    }
};
