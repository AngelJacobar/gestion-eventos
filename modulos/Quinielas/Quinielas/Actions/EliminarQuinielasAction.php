<?php

namespace Modulos\Quinielas\Quinielas\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modulos\Quinielas\Models\Quinielas;

class EliminarQuinielasAction
{
    public static function execute($idQuiniela)
    {
        try {
            return DB::transaction(function () use ($idQuiniela)
            {
                $quiniela = Quinielas::findOrFail($idQuiniela);
                $quiniela->delete();
                return $quiniela;
                
            });

        }catch (Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        }        

    }
}
    