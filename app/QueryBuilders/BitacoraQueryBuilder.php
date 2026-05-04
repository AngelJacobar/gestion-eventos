<?php

namespace App\QueryBuilders;

use App\Enums\RegistroTipoEnum;
use App\Models\Bitacora;
use Illuminate\Database\Eloquent\Builder;

class BitacoraQueryBuilder extends Builder
{
    public static function registrar($idAccion, $idUsuario, $registroId, ?RegistroTipoEnum $registroTipo = null)
    {
        $bitacora = new Bitacora(
            [
                'id_accion' => $idAccion,
                'id_usuario' => $idUsuario,
                'registro_id' => $registroId,
                'descripcion' => $registroTipo !== null ? $registroTipo->descripcion() : null,
                'registro_tipo' => $registroTipo !== null ? $registroTipo->registroTipo() : null,
            ]
        );

        $bitacora->save();
    }
}
