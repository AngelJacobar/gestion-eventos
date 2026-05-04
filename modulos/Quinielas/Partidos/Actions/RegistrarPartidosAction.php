<?php

namespace Modulos\Quinielas\Partidos\Actions;

use App\Enums\AccionEnum;
use App\Enums\RegistroTipoEnum;
use App\Livewire\Forms\Partidos\RegistrarPartidosForm;
use App\Models\Bitacora;
use Illuminate\Support\Facades\DB;
use Modulos\Quinielas\Models\PartidosSemana;

class RegistrarPartidosAction
{
    public static function execute(RegistrarPartidosForm $form, $idUsuario, $idPartido = null)
    {
        return DB::transaction(function () use ($form, $idUsuario, $idPartido) {
            $idAccion = $idPartido ? AccionEnum::Modificacion : AccionEnum::Registro;
            if($idPartido){
                $partido = PartidosSemana::findOrFail($idPartido);
                $partido->update([
                    'jornada' => $form->jornada,
                    'numero_partido' => $form->numero_partido,
                    'equipo_local' => $form->equipo_local,
                    'equipo_visitante' => $form->equipo_visitante,
                    'fecha_partido' => $form->fecha_partido,
                    'resultado' => $form->resultado,
                    'fecha_inicio_jornada' => $form->fecha_inicio_jornada,
                    'fecha_fin_jornada' => $form->fecha_fin_jornada,
                    'updated_at' => now()
                ]);
            }else{
                $partido = PartidosSemana::create([
                    'jornada' => $form->jornada,
                    'numero_partido' => $form->numero_partido,
                    'equipo_local' => $form->equipo_local,
                    'equipo_visitante' => $form->equipo_visitante,
                    'fecha_partido' => $form->fecha_partido,
                    'resultado' => null,
                    'estatus' => 'S',
                    'fecha_inicio_jornada' => $form->fecha_inicio_jornada,
                    'fecha_fin_jornada' => $form->fecha_fin_jornada,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            Bitacora::registrar($idAccion, $idUsuario, $partido->id_partido,  RegistroTipoEnum::Partido);
            return $partido;
        });
    }
}