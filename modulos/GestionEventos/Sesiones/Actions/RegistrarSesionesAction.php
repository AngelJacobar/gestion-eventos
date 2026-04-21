<?php

namespace Modulos\GestionEventos\Sesiones\Actions;

use App\Enums\AccionEnum;
use App\Enums\EstatusEnum;
use App\Enums\RegistroTipoEnum;
use App\Livewire\Forms\Sesiones\RegistrarSesionesForm;
use App\Models\Bitacora;
use Illuminate\Support\Facades\DB;
use Modulos\GestionEventos\Models\Sesion;



class RegistrarSesionesAction
{
    public static function execute(RegistrarSesionesForm $form, $idUsuario, $idSesion = null)
    {
        return DB::transaction(function () use ($form, $idUsuario, $idSesion) {
            $idAccion = $idSesion ? AccionEnum::Modificacion : AccionEnum::Registro;

            if($idSesion){
                $sesion = Sesion::findOrFail($idSesion);
                $sesion->update([
                    'id_evento' => $form->id_evento,
                    'nombre' => $form->nombre,
                    'fecha' => $form->fecha,
                    'hora_inicio' => $form->hora_inicio,
                    'hora_fin' => $form->hora_fin,
                    'ponente' => $form->ponente,
                    'activo' => EstatusEnum::Activo->value
                ]);
            }else{
                $sesion = Sesion::create([
                    'id_evento' => $form->id_evento,
                    'nombre' => $form->nombre,
                    'fecha' => $form->fecha,
                    'hora_inicio' => $form->hora_inicio,
                    'hora_fin' => $form->hora_fin,
                    'ponente' => $form->ponente,
                    'activo' => EstatusEnum::Activo->value
                ]);
            }
            Bitacora::registrar($idAccion, $idUsuario, $sesion->id_sesion,  RegistroTipoEnum::Sesion);
            return $sesion;
        });
    }
}