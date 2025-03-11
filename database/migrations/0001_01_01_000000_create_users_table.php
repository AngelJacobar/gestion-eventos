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
        Schema::create('usuario', function (Blueprint $table) {
            $table->comment('Registro de usuarios del sistema.');
            $table->id('id_usuario')->comment('Identificador del usuario, por ejemplo: 10.');
            $table->string('nombre')->comment('Nombre del usuario, por ejemplo: Juan.');
            $table->string('primer_apellido')->comment('Primer apellido del usuario, por ejemplo: López.');
            $table->string('segundo_apellido')->nullable()->comment('Segundo apellido del usuario, por ejemplo: Pérez.');
            $table->char('activo', length: 1)->default('S')->comment('Indica si el usuario se encuentra activo = T, inactivo = F.');
            $table->string('email')->unique()->comment('Correo electrónico del usuario, por ejemplo: usuario_prueba@unam.mx.');
            $table->string('curp')->unique()->nullable()->comment('CURP del usuario.');
            $table->string('numero_cuenta')->unique()->nullable()->comment('Número de cuenta del alumno.');
            $table->string('numero_trabajador')->unique()->nullable()->comment('Número de trabajador.');
            $table->timestamp('email_verified_at')->nullable()->comment('Campo usado por laravel para verificar el email.');
            $table->string('password')->comment('Password cifrado del usuario.');
            $table->rememberToken()->comment('Campo usado por laravel para saber si debe recordar el token.');
            $table->timestamp('created_at')->comment('Fecha y hora de creación del registro.');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última modificación del registro.');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
