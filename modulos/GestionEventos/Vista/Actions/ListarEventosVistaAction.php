<?php

namespace Modulos\GestionEventos\Vista\Actions;

use App\Livewire\Forms\Vista\BuscarEventosVistaForm;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modulos\GestionEventos\Vista\Enums\BuscarEventosVistaFilterEnum;
use Modulos\GestionEventos\Models\Evento;

class ListarEventosVistaAction
{
    public static function execute(BuscarEventosVistaForm $form)
    {
        try {
            $filters = collect($form->validate())
                ->map(function (mixed $value, string $key) {
                    return BuscarEventosVistaFilterEnum::from($key)->createFilter($value);
                })
                ->values()
                ->all();
            return app(Pipeline::class)
                ->send(Evento::buscar())
                ->through($filters)
                ->thenReturn();
        } catch(ValidationException $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            throw $e;
        }
    }
}
