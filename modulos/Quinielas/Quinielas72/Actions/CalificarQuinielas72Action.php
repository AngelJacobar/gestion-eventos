<?php

namespace Modulos\Quinielas\Quinielas72\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modulos\Quinielas\Models\Partidos72;
use Modulos\Quinielas\Models\Quinielas72;
use Modulos\Quinielas\Models\QuinielasDetalle72;

class CalificarQuinielas72Action
{
    public static function execute()
    {
        return DB::transaction(function () {
            Log::info('Iniciando calificación de quinielas de 72 partidos');
            
            // Primero reiniciamos todos los puntajes a 0 y el campo acierto a null
            $quinielasReiniciadas = Quinielas72::where('estatus', 'S')->update(['puntaje_total' => 0]);
            QuinielasDetalle72::whereHas('quiniela', function ($query) {
                $query->where('estatus', 'S');
            })->update(['acierto' => null]);
            
            Log::info("Puntajes reiniciados", ['quinielas_reiniciadas' => $quinielasReiniciadas]);

            // Obtener todos los partidos con resultado
            $partidos = Partidos72::whereNotNull('resultado')
                ->orderBy('numero_partido', 'asc')
                ->get();

            Log::info("Partidos con resultado obtenidos", ['total_partidos' => $partidos->count()]);

            $partidosCalificados = 0;
            $puntosOtorgados = 0;

            // Recorrer cada partido
            foreach ($partidos as $partido) {
                if ($partido->resultado !== null && $partido->resultado !== '') {
                    Log::info("Calificando partido", [
                        'id' => $partido->id_partido_72,
                        'numero' => $partido->numero_partido,
                        'resultado' => $partido->resultado
                    ]);

                    // Buscar todos los detalles que acertaron este partido
                    $detallesAcertados = QuinielasDetalle72::where('id_partido_72', $partido->id_partido_72)
                        ->where('pronostico', $partido->resultado)
                        ->whereHas('quiniela', function ($query) {
                            $query->where('estatus', 'S');
                        })
                        ->get();

                    Log::info("Detalles que acertaron", [
                        'partido' => $partido->numero_partido,
                        'acertados' => $detallesAcertados->count()
                    ]);

                    // Marcar como acierto y sumar punto a cada quiniela
                    foreach ($detallesAcertados as $detalle) {
                        $detalle->update(['acierto' => true]);
                        $detalle->quiniela->increment('puntaje_total', 1);
                        $puntosOtorgados++;
                    }

                    // Marcar como fallo los pronósticos incorrectos de este partido
                    QuinielasDetalle72::where('id_partido_72', $partido->id_partido_72)
                        ->where('pronostico', '!=', $partido->resultado)
                        ->whereHas('quiniela', function ($query) {
                            $query->where('estatus', 'S');
                        })
                        ->update(['acierto' => false]);

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
