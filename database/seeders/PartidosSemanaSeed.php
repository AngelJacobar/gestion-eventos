<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PartidosSemanaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partidos = [
            [
                'numero_partido' => 1,
                'equipo_local' => 'América',
                'equipo_visitante' => 'Guadalajara',
                'resultado' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_partido' => 2,
                'equipo_local' => 'Cruz Azul',
                'equipo_visitante' => 'Pumas',
                'resultado' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_partido' => 3,
                'equipo_local' => 'Monterrey',
                'equipo_visitante' => 'Tigres',
                'resultado' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_partido' => 4,
                'equipo_local' => 'Toluca',
                'equipo_visitante' => 'Santos',
                'resultado' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_partido' => 5,
                'equipo_local' => 'Atlas',
                'equipo_visitante' => 'León',
                'resultado' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_partido' => 6,
                'equipo_local' => 'Pachuca',
                'equipo_visitante' => 'Querétaro',
                'resultado' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_partido' => 7,
                'equipo_local' => 'Puebla',
                'equipo_visitante' => 'Necaxa',
                'resultado' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_partido' => 8,
                'equipo_local' => 'Mazatlán',
                'equipo_visitante' => 'Tijuana',
                'resultado' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_partido' => 9,
                'equipo_local' => 'Juárez',
                'equipo_visitante' => 'San Luis',
                'resultado' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($partidos as $partido) {
            DB::table('partidos_semana')->insert($partido);
        }
    }
}
