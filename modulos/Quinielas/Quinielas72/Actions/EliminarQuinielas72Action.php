<?php

namespace Modulos\Quinielas\Quinielas72\Actions;

use App\Enums\AccionEnum;
use App\Enums\RegistroTipoEnum;
use App\Models\Bitacora;
use Illuminate\Support\Facades\DB;
use Modulos\Quinielas\Models\Quinielas72;
use Modulos\Quinielas\Models\QuinielasDetalle72;

class EliminarQuinielas72Action
{
    public static function execute($idQuiniela72, $idUsuario)
    {
        return DB::transaction(function () use ($idQuiniela72, $idUsuario) {
            $quiniela = Quinielas72::findOrFail($idQuiniela72);
            
            // Eliminar detalles primero (aunque la FK on cascade lo haría automáticamente)
            QuinielasDetalle72::where('id_quiniela_72', $idQuiniela72)->delete();
            
            // Eliminar la quiniela
            $quiniela->delete();
            
            Bitacora::registrar(AccionEnum::Eliminacion, $idUsuario, $idQuiniela72, RegistroTipoEnum::Quiniela);
            
            return true;
        });
    }
}
