<?php

namespace Modulos\Usuarios\Actions;

use App\Enums\AccionEnum;
use App\Enums\RegistroTipoEnum;
use App\Livewire\Forms\Usuarios\RegistrarUsuarioForm;
use App\Models\Bitacora;
use App\Models\Usuario;
use App\Traits\UppercaseTransform;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Modulos\Usuarios\Notifications\UsuarioRegistradoNotification;

class RegistrarUsuarioAction
{
    use UppercaseTransform;

    public static function execute(RegistrarUsuarioForm $form, int $idUsuario)
    {
        try {
            $form = self::formToUppercase($form, ['email','rol']);
            $form->validate();

            return DB::transaction(function () use ($form, $idUsuario) {
                $idAccion = $form->id_usuario
                    ? AccionEnum::Modificacion
                    : AccionEnum::Registro;

                $usuario = new Usuario();

                $idAccion === AccionEnum::Registro
                ?
                    $usuario = Usuario::create([
                        ...$form->all(),
                        'password' => '',
                    ])

                :
                    $usuario = tap(Usuario::find($form->id_usuario))->update($form->all())
                ;

                $usuario->syncRoles($form->rol);

                if ($idAccion === AccionEnum::Registro) {
                    $usuario->notify(new UsuarioRegistradoNotification($usuario));
                    Password::sendResetLink(['email' => $usuario->email]);
                }

                Bitacora::registrar($idAccion, $idUsuario, $usuario->id_usuario, RegistroTipoEnum::Usuario);
                return $usuario;
            });
        } catch (Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        }
    }
}
