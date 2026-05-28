<?php

namespace Modulos\Quinielas\Partidos72\Actions;

use App\Enums\AccionEnum;
use App\Enums\RegistroTipoEnum;
use App\Livewire\Forms\Partidos72\RegistrarPartidos72Form;
use App\Models\Bitacora;
use Illuminate\Support\Facades\DB;
use Modulos\Quinielas\Models\Partidos72;

class RegistrarPartidos72Action
{
    public static function execute(RegistrarPartidos72Form $form, $idUsuario, $idPartido72 = null)
    {
        return DB::transaction(function () use ($form, $idUsuario, $idPartido72) {
            $idAccion = $idPartido72 ? AccionEnum::Modificacion : AccionEnum::Registro;
            
            if ($idPartido72) {
                $partido = Partidos72::findOrFail($idPartido72);
                $partido->update([
                    'numero_partido' => $form->numero_partido,
                    'equipo_local' => $form->equipo_local,
                    'equipo_visitante' => $form->equipo_visitante,
                    'resultado' => $form->resultado,
                    'updated_at' => now()
                ]);
            } else {
                $partido = Partidos72::create([
                    'numero_partido' => $form->numero_partido,
                    'equipo_local' => $form->equipo_local,
                    'equipo_visitante' => $form->equipo_visitante,
                    'resultado' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            Bitacora::registrar($idAccion, $idUsuario, $partido->id_partido_72, RegistroTipoEnum::Partido);
            return $partido;
        });
    }
}
