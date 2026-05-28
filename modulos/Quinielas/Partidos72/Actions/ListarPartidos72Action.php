<?php

namespace Modulos\Quinielas\Partidos72\Actions;

use App\Livewire\Forms\Partidos72\BuscarPartidos72Form;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modulos\Quinielas\Models\Partidos72;

class ListarPartidos72Action
{
    public static function execute(BuscarPartidos72Form $form)
    {
        try {
            // No hay filtros disponibles actualmente
            return Partidos72::query()->orderBy('numero_partido', 'asc');
        } catch (ValidationException $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '(' . $e->getLine() . '): ' . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '(' . $e->getLine() . '): ' . $e->getMessage());
            throw $e;
        }
    }
}
