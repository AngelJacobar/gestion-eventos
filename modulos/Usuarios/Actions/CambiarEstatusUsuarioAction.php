<?php

namespace Modulos\Usuarios\Actions;

use App\Enums\AccionEnum;
use App\Enums\EstatusEnum;
use App\Enums\RegistroTipoEnum;
use App\Models\Bitacora;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CambiarEstatusUsuarioAction
{
    public static function execute(int $idUsuario, $idUsuarioModificador)
    {
        try {
            return DB::transaction(function () use ($idUsuario, $idUsuarioModificador) {
                $usuario = Usuario::find($idUsuario);
                $usuario->activo = $usuario->activo === EstatusEnum::Activo
                    ? EstatusEnum::Inactivo
                    : EstatusEnum::Activo;
                $usuario->save();

                Bitacora::registrar(
                    AccionEnum::CambiarEstatus,
                    $idUsuarioModificador,
                    $idUsuario,
                    RegistroTipoEnum::Usuario
                );

                // Si el usuario que se desactiva es diferente al usuario que lo desactiva, se cierran todas las sesiones
                // La sesion del usuario en sesion la cierra el componente para poder enviarle un aviso
                if ($idUsuario != $idUsuarioModificador) {
                    DB::table('sessions')->where('user_id', $idUsuario)->delete();
                }

                return $usuario;
            });
        } catch (Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        }
    }
}
