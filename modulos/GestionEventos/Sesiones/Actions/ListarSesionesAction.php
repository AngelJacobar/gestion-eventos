<?php

namespace Modulos\GestionEventos\Sesiones\Actions;

use App\Livewire\Forms\Sesiones\BuscarSesionesForm;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modulos\GestionEventos\Sesiones\Enums\BuscarSesionesFilterEnum;
use Modulos\GestionEventos\Models\Sesion;

class ListarSesionesAction
{
    public static function execute(BuscarSesionesForm $form)
    {
        try {
            $filters = collect($form->validate())
                ->map(function (mixed $value, string $key) {
                    return BuscarSesionesFilterEnum::from($key)->createFilter($value);
                })
                ->values()
                ->all();
            return app(Pipeline::class)
                ->send(Sesion::buscar())
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

