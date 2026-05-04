<?php

namespace Modulos\GestionEventos\Evento\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modulos\GestionEventos\Models\Evento;

class EliminarEventoAction
{
    public static function execute($idEvento)
    {
        try {
            return DB::transaction(function () use ($idEvento)
            {
                $evento = Evento::findOrFail($idEvento);
                $evento->delete();
                return $evento;
                
            });

        }catch (Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        }        

    }
}
    