<?php

namespace Modulos\Quinielas\Partidos\Actions;

use App\Livewire\Forms\Partidos\BuscarPartidosForm;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modulos\Quinielas\Models\PartidosSemana;

class ListarPartidosAction
{
    public static function execute(BuscarPartidosForm $form)
    {
        try {
            // No hay filtros disponibles actualmente
            return PartidosSemana::query();
        } catch(ValidationException $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        }
    }
}
