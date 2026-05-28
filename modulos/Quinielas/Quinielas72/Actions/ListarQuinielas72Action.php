<?php

namespace Modulos\Quinielas\Quinielas72\Actions;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modulos\Quinielas\Models\Quinielas72;

class ListarQuinielas72Action
{
    public static function execute()
    {
        try {
            return Quinielas72::query()
                ->orderBy('puntaje_total', 'desc')
                ->orderBy('fecha_registro', 'asc');
        } catch (ValidationException $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '(' . $e->getLine() . '): ' . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '(' . $e->getLine() . '): ' . $e->getMessage());
            throw $e;
        }
    }
}
