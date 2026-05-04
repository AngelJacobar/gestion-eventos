<?php

namespace Modulos\Quinielas\Quinielas\Actions;

use Illuminate\Support\Facades\DB;
use Modulos\Quinielas\Models\PartidosSemana;
use Modulos\Quinielas\Models\Quinielas;

class CalificarQuinielasAction
{
    public static function execute()
    {
        return DB::transaction(function () {
            // Primero reiniciamos todos los puntajes a 0
            Quinielas::where('estatus', 'S')->update(['puntaje_total' => 0]);

            // Obtener todos los partidos activos
            $partidos = PartidosSemana::where('estatus', 'S')
                ->orderBy('numero_partido', 'asc')
                ->get();

            // Recorrer cada partido
            foreach ($partidos as $partido) {
                // Verificar si el partido tiene resultado
                if ($partido->resultado !== null && $partido->resultado !== '') {
                    $numeroPartido = $partido->numero_partido;
                    $resultado = $partido->resultado;

                    // Buscar todas las quinielas activas que acertaron este partido
                    $quinielas = Quinielas::where('estatus', 'S')
                        ->where('pronostico_' . $numeroPartido, $resultado)
                        ->get();

                    // Sumar 1 punto a cada quiniela que acertó
                    foreach ($quinielas as $quiniela) {
                        $quiniela->increment('puntaje_total', 1);
                    }
                }
            }

            return true;
        });
    }
}
