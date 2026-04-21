<?php

namespace Modulos\GestionEventos\Sesiones\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modulos\GestionEventos\Models\Sesion;

class EliminarSesionAction
{
    public static function execute($idSesiones)
    {
        try {
            return DB::transaction(function () use ($idSesiones)
            {
                $Sesiones = Sesion::findOrFail($idSesiones);
                $Sesiones->delete();
                return $Sesiones;
                
            });

        }catch (Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        }        

    }
}
    