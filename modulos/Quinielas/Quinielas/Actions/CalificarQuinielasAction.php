<?php

namespace Modulos\Quinielas\Quinielas\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modulos\Quinielas\Models\PartidosSemana;
use Modulos\Quinielas\Models\Quinielas;

class CalificarQuinielasAction
{
    public static function execute()
    {
        return DB::transaction(function () {
            Log::info('Iniciando calificación de quinielas');
            
            // Primero reiniciamos todos los puntajes a 0
            $quinielasReiniciadas = Quinielas::where('estatus', 'S')->update(['puntaje_total' => 0]);
            Log::info("Puntajes reiniciados", ['quinielas_reiniciadas' => $quinielasReiniciadas]);

            // Obtener todos los partidos activos
            $partidos = PartidosSemana::orderBy('numero_partido', 'asc')
                ->get();

            Log::info("Partidos obtenidos", ['total_partidos' => $partidos->count()]);

            $partidosCalificados = 0;
            $puntosOtorgados = 0;

            // Recorrer cada partido
            foreach ($partidos as $partido) {
                // Verificar si el partido tiene resultado
                if ($partido->resultado !== null && $partido->resultado !== '') {
                    $numeroPartido = $partido->numero_partido;
                    $resultado = $partido->resultado;

                    Log::info("Calificando partido", [
                        'numero' => $numeroPartido,
                        'resultado' => $resultado
                    ]);

                    // Buscar todas las quinielas activas que acertaron este partido
                    $quinielas = Quinielas::where('estatus', 'S')
                        ->where('pronostico_' . $numeroPartido, $resultado)
                        ->get();

                    Log::info("Quinielas acertaron", [
                        'partido' => $numeroPartido,
                        'acertadas' => $quinielas->count()
                    ]);

                    // Sumar 1 punto a cada quiniela que acertó
                    foreach ($quinielas as $quiniela) {
                        $quiniela->increment('puntaje_total', 1);
                        $puntosOtorgados++;
                    }

                    $partidosCalificados++;
                }
            }

            Log::info("Calificación completada", [
                'partidos_calificados' => $partidosCalificados,
                'puntos_otorgados' => $puntosOtorgados
            ]);

            return true;
        });
    }
}
