<?php

namespace Modulos\GestionEventos\Evento\Actions;

use App\Enums\AccionEnum;
use App\Enums\EstatusEnum;
use App\Enums\RegistroTipoEnum;
use App\Livewire\Forms\Eventos\RegistrarEventosForm;
use App\Models\Bitacora;
use Illuminate\Support\Facades\DB;
use Modulos\GestionEventos\Models\Evento;



class RegistrarEventosAction
{
    public static function execute(RegistrarEventosForm $form, $idUsuario, $idEvento = null)
    {
        return DB::transaction(function () use ($form, $idUsuario, $idEvento) {
            $idAccion = $idEvento ? AccionEnum::Modificacion : AccionEnum::Registro;

            if($idEvento){
                $evento = Evento::findOrFail($idEvento);
                $evento->update([
                    'id_usuario' => $idUsuario,
                    'nombre' => $form->nombre,
                    'fecha_inicio' => $form->fecha_inicio,
                    'fecha_fin' => $form->fecha_fin,
                    'lugar' => $form->lugar,
                    'capacidad' => $form->capacidad,
                    'activo' => EstatusEnum::Activo->value
                ]);
            }else{
                $evento = Evento::create([
                    'id_usuario' => $idUsuario,
                    'nombre' => $form->nombre,
                    'fecha_inicio' => $form->fecha_inicio,
                    'fecha_fin' => $form->fecha_fin,
                    'lugar' => $form->lugar,
                    'capacidad' => $form->capacidad,
                    'activo' => EstatusEnum::Activo->value
                ]);
            }
            Bitacora::registrar($idAccion, $idUsuario, $evento->id_evento,  RegistroTipoEnum::Evento);
            return $evento;
        });
    }
}