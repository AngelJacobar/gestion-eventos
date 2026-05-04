<?php

namespace Modulos\Quinielas\Quinielas\Actions;

use App\Enums\AccionEnum;
use App\Enums\RegistroTipoEnum;
use App\Livewire\Forms\Quinielas\RegistrarQuinielasForm;
use App\Models\Bitacora;
use Illuminate\Support\Facades\DB;
use Modulos\Quinielas\Models\Quinielas;

class RegistrarQuinielasAction
{
    public static function execute(RegistrarQuinielasForm $form, $idUsuario, $idQuiniela = null)
    {
        return DB::transaction(function () use ($form, $idUsuario, $idQuiniela) {
            $idAccion = $idQuiniela ? AccionEnum::Modificacion : AccionEnum::Registro;
            if($idQuiniela){
                $quiniela = Quinielas::findOrFail($idQuiniela);
                $quiniela->update([
                    'jornada' => $form->jornada,
                    'nombre' => $form->nombre,
                    'telefono' => $form->telefono,
                    'pronostico_1' => $form->pronostico_1,
                    'pronostico_2' => $form->pronostico_2,
                    'pronostico_3' => $form->pronostico_3,
                    'pronostico_4' => $form->pronostico_4,
                    'pronostico_5' => $form->pronostico_5,
                    'pronostico_6' => $form->pronostico_6,
                    'pronostico_7' => $form->pronostico_7,
                    'pronostico_8' => $form->pronostico_8,
                    'pronostico_9' => $form->pronostico_9,
                    'puntaje_total' => $form->puntaje_total,
                    'fecha_registro' => $form->fecha_registro,
                    'updated_at' => now()
                ]);
            }else{
                $quiniela = Quinielas::create([
                    'jornada' => $form->jornada,
                    'nombre' => $form->nombre,
                    'telefono' => $form->telefono,
                    'pronostico_1' => $form->pronostico_1,
                    'pronostico_2' => $form->pronostico_2,
                    'pronostico_3' => $form->pronostico_3,
                    'pronostico_4' => $form->pronostico_4,
                    'pronostico_5' => $form->pronostico_5,
                    'pronostico_6' => $form->pronostico_6,
                    'pronostico_7' => $form->pronostico_7,
                    'pronostico_8' => $form->pronostico_8,
                    'pronostico_9' => $form->pronostico_9,
                    'puntaje_total' => $form->puntaje_total ?? 0,
                    'estatus' => 'S',
                    'fecha_registro' => $form->fecha_registro ?? now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            Bitacora::registrar($idAccion, $idUsuario, $quiniela->id_quiniela,  RegistroTipoEnum::Quiniela);
            return $quiniela;
        });
    }
}