<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accion')->insert([
            'id_accion' => 1,
            'nombre' => 'Registro',
        ]);
        DB::table('accion')->insert([
            'id_accion' => 2,
            'nombre' => 'Modificación',
        ]);
        DB::table('accion')->insert([
            'id_accion' => 3,
            'nombre' => 'Eliminación',
        ]);
        DB::table('accion')->insert([
            'id_accion' => 4,
            'nombre' => 'Inicio de sesión',
        ]);
        DB::table('accion')->insert([
            'id_accion' => 5,
            'nombre' => 'Cierre de sesión',
        ]);
        DB::table('accion')->insert([
            'id_accion' => 6,
            'nombre' => 'Cambio de contraseña',
        ]);
        DB::table('accion')->insert([
            'id_accion' => 7,
            'nombre' => 'Recuperación de contraseña',
        ]);
        DB::table('accion')->insert([
            'id_accion' => 8,
            'nombre' => 'Cambiar estatus',
        ]);

    }
}
