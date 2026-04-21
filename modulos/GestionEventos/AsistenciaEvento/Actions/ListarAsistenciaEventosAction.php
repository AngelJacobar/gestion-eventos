<?php

namespace Modulos\GestionEventos\AsistenciaEvento\Actions;

use App\Livewire\Forms\AsistenciaEvento\BuscarAsistenciaEventosForm;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modulos\GestionEventos\AsistenciaEvento\Enums\BuscarAsistenciaEventosFilterEnum;
use Modulos\GestionEventos\Models\AsistenteEvento;

class ListarAsistenciaEventosAction
{
    public static function execute(BuscarAsistenciaEventosForm $form)
    {
        try {
            $filters = collect($form->validate())
                ->map(function (mixed $value, string $key) {
                    return BuscarAsistenciaEventosFilterEnum::from($key)->createFilter($value);
                })
                ->values()
                ->all();
            return app(Pipeline::class)
                ->send(AsistenteEvento::buscar())
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
