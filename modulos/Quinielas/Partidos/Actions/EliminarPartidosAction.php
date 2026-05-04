<?php

namespace Modulos\Quinielas\Partidos\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modulos\Quinielas\Models\PartidosSemana;

class EliminarPartidosAction
{
    public static function execute($idPartido)
    {
        try {
            return DB::transaction(function () use ($idPartido)
            {
                $partido = PartidosSemana::findOrFail($idPartido);
                $partido->delete();
                return $partido;
                
            });

        }catch (Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        }        

    }
}
    