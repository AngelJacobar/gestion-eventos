<?php

namespace Modulos\GestionEventos\AsistenciaEvento\Actions;

use App\Enums\AccionEnum;
use App\Enums\EstatusEnum;
use App\Enums\RegistroTipoEnum;
use App\Livewire\Forms\AsistenciaEvento\RegistrarAsistenciaEventosForm;
use App\Models\Bitacora;
use Illuminate\Support\Facades\DB;
use Modulos\GestionEventos\Models\AsistenteEvento;

class RegistrarAsistenciaEventosAction
{
    public static function execute(RegistrarAsistenciaEventosForm $form, $idUsuario, $idAsistenciaEvento = null)
    {
        return DB::transaction(function () use ($form, $idUsuario, $idAsistenciaEvento) {
            $idAccion = $idAsistenciaEvento ? AccionEnum::Modificacion : AccionEnum::Registro;

            if($idAsistenciaEvento){
                $asistenciaEvento = AsistenteEvento::findOrFail($idAsistenciaEvento);
                $asistenciaEvento->update([
                    'id_usuario' => $form->id_usuario,
                    'id_evento' => $form->id_evento,
                    'fecha_registro' => $form->fecha_registro,
                    'activo' => EstatusEnum::Activo->value
                ]);
            }else{
                $asistenciaEvento = AsistenteEvento::create([
                    'id_usuario' => $form->id_usuario,
                    'id_evento' => $form->id_evento,
                    'fecha_registro' => $form->fecha_registro,
                    'activo' => EstatusEnum::Activo->value
                ]);
            }
            Bitacora::registrar($idAccion, $idUsuario, $asistenciaEvento->id_asistente_evento,  RegistroTipoEnum::Evento);
            return $asistenciaEvento;
        });
    }
}