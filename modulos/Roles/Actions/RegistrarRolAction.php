<?php

namespace Modulos\Roles\Actions;

use App\Enums\AccionEnum;
use App\Enums\RegistroTipoEnum;
use App\Livewire\Forms\Roles\RegistrarRolForm;
use App\Models\Bitacora;
use App\Traits\UppercaseTransform;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RegistrarRolAction
{
    use UppercaseTransform;

    public static function execute(RegistrarRolForm $form, int $idUsuario)
    {
        try {
            $form->validate();

            return DB::transaction(function () use ($form, $idUsuario) {
                $idAccion = $form->id_rol
                    ? AccionEnum::Modificacion
                    : AccionEnum::Registro;

                $permisos = Permission::find($form->permisos);

                $rol = Role::updateOrCreate(
                    ['id' => $form->id_rol],
                    ['name' => $form->nombre]
                );

                $rol->syncPermissions($permisos);

                Bitacora::registrar($idAccion, $idUsuario, $rol->id, RegistroTipoEnum::Rol);
                return $rol;
            });
        } catch (Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        }
    }
}
