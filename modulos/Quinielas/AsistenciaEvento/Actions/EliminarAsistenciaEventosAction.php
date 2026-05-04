<?php

namespace Modulos\GestionEventos\AsistenciaEvento\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modulos\GestionEventos\Models\AsistenteEvento;

class EliminarAsistenciaEventosAction
{
    public static function execute($idAsistenciaEvento)
    {
        try {
            return DB::transaction(function () use ($idAsistenciaEvento)
            {
                $asistenciaEvento = AsistenteEvento::findOrFail($idAsistenciaEvento);
                $asistenciaEvento->delete();
                return $asistenciaEvento;
                
            });

        }catch (Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        }        

    }
}
    