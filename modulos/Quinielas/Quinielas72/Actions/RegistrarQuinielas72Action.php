<?php

namespace Modulos\Quinielas\Quinielas72\Actions;

use App\Enums\AccionEnum;
use App\Enums\RegistroTipoEnum;
use App\Livewire\Forms\Quinielas72\RegistrarQuinielas72Form;
use App\Models\Bitacora;
use Illuminate\Support\Facades\DB;
use Modulos\Quinielas\Models\Quinielas72;
use Modulos\Quinielas\Models\QuinielasDetalle72;

class RegistrarQuinielas72Action
{
    public static function execute(RegistrarQuinielas72Form $form, $idUsuario, $idQuiniela72 = null)
    {
        return DB::transaction(function () use ($form, $idUsuario, $idQuiniela72) {
            $idAccion = $idQuiniela72 ? AccionEnum::Modificacion : AccionEnum::Registro;
            
            if ($idQuiniela72) {
                // Actualizar quiniela existente
                $quiniela = Quinielas72::findOrFail($idQuiniela72);
                $quiniela->update([
                    'jornada' => $form->jornada,
                    'nombre' => $form->nombre,
                    'telefono' => $form->telefono,
                    'puntaje_total' => $form->puntaje_total,
                    'estatus' => $form->estatus,
                    'fecha_registro' => $form->fecha_registro,
                    'updated_at' => now()
                ]);

                // Eliminar detalles anteriores y crear nuevos
                QuinielasDetalle72::where('id_quiniela_72', $idQuiniela72)->delete();
                
                // Crear nuevos detalles
                foreach ($form->pronosticos as $idPartido72 => $pronostico) {
                    QuinielasDetalle72::create([
                        'id_quiniela_72' => $quiniela->id_quiniela_72,
                        'id_partido_72' => $idPartido72,
                        'pronostico' => $pronostico,
                        'acierto' => null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            } else {
                // Crear nueva quiniela
                $quiniela = Quinielas72::create([
                    'jornada' => $form->jornada,
                    'nombre' => $form->nombre,
                    'telefono' => $form->telefono,
                    'puntaje_total' => $form->puntaje_total ?? 0,
                    'estatus' => 'S',
                    'fecha_registro' => $form->fecha_registro ?? now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Crear detalles de pronósticos
                foreach ($form->pronosticos as $idPartido72 => $pronostico) {
                    QuinielasDetalle72::create([
                        'id_quiniela_72' => $quiniela->id_quiniela_72,
                        'id_partido_72' => $idPartido72,
                        'pronostico' => $pronostico,
                        'acierto' => null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
            
            Bitacora::registrar($idAccion, $idUsuario, $quiniela->id_quiniela_72, RegistroTipoEnum::Quiniela);
            return $quiniela;
        });
    }
}
