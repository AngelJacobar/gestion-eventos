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
        $fechaInicioJornada = Carbon::now()->startOfWeek();
        $fechaFinJornada = Carbon::now()->endOfWeek();

        $partidos = [
            [
                'jornada' => 'Jornada 1',
                'numero_partido' => 1,
                'equipo_local' => 'América',
                'equipo_visitante' => 'Guadalajara',
                'fecha_partido' => $fechaInicioJornada->copy()->addDays(1)->setTime(19, 0),
                'resultado' => null,
                'estatus' => 'S',
                'fecha_inicio_jornada' => $fechaInicioJornada,
                'fecha_fin_jornada' => $fechaFinJornada,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jornada' => 'Jornada 1',
                'numero_partido' => 2,
                'equipo_local' => 'Cruz Azul',
                'equipo_visitante' => 'Pumas',
                'fecha_partido' => $fechaInicioJornada->copy()->addDays(1)->setTime(21, 0),
                'resultado' => null,
                'estatus' => 'S',
                'fecha_inicio_jornada' => $fechaInicioJornada,
                'fecha_fin_jornada' => $fechaFinJornada,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jornada' => 'Jornada 1',
                'numero_partido' => 3,
                'equipo_local' => 'Monterrey',
                'equipo_visitante' => 'Tigres',
                'fecha_partido' => $fechaInicioJornada->copy()->addDays(2)->setTime(19, 0),
                'resultado' => null,
                'estatus' => 'S',
                'fecha_inicio_jornada' => $fechaInicioJornada,
                'fecha_fin_jornada' => $fechaFinJornada,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jornada' => 'Jornada 1',
                'numero_partido' => 4,
                'equipo_local' => 'Toluca',
                'equipo_visitante' => 'Santos',
                'fecha_partido' => $fechaInicioJornada->copy()->addDays(2)->setTime(21, 0),
                'resultado' => null,
                'estatus' => 'S',
                'fecha_inicio_jornada' => $fechaInicioJornada,
                'fecha_fin_jornada' => $fechaFinJornada,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jornada' => 'Jornada 1',
                'numero_partido' => 5,
                'equipo_local' => 'Atlas',
                'equipo_visitante' => 'León',
                'fecha_partido' => $fechaInicioJornada->copy()->addDays(3)->setTime(18, 0),
                'resultado' => null,
                'estatus' => 'S',
                'fecha_inicio_jornada' => $fechaInicioJornada,
                'fecha_fin_jornada' => $fechaFinJornada,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jornada' => 'Jornada 1',
                'numero_partido' => 6,
                'equipo_local' => 'Pachuca',
                'equipo_visitante' => 'Querétaro',
                'fecha_partido' => $fechaInicioJornada->copy()->addDays(3)->setTime(20, 0),
                'resultado' => null,
                'estatus' => 'S',
                'fecha_inicio_jornada' => $fechaInicioJornada,
                'fecha_fin_jornada' => $fechaFinJornada,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jornada' => 'Jornada 1',
                'numero_partido' => 7,
                'equipo_local' => 'Puebla',
                'equipo_visitante' => 'Necaxa',
                'fecha_partido' => $fechaInicioJornada->copy()->addDays(4)->setTime(17, 0),
                'resultado' => null,
                'estatus' => 'S',
                'fecha_inicio_jornada' => $fechaInicioJornada,
                'fecha_fin_jornada' => $fechaFinJornada,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jornada' => 'Jornada 1',
                'numero_partido' => 8,
                'equipo_local' => 'Mazatlán',
                'equipo_visitante' => 'Tijuana',
                'fecha_partido' => $fechaInicioJornada->copy()->addDays(4)->setTime(19, 0),
                'resultado' => null,
                'estatus' => 'S',
                'fecha_inicio_jornada' => $fechaInicioJornada,
                'fecha_fin_jornada' => $fechaFinJornada,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jornada' => 'Jornada 1',
                'numero_partido' => 9,
                'equipo_local' => 'Juárez',
                'equipo_visitante' => 'San Luis',
                'fecha_partido' => $fechaInicioJornada->copy()->addDays(4)->setTime(21, 0),
                'resultado' => null,
                'estatus' => 'S',
                'fecha_inicio_jornada' => $fechaInicioJornada,
                'fecha_fin_jornada' => $fechaFinJornada,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($partidos as $partido) {
            DB::table('partidos_semana')->insert($partido);
        }
    }
}
