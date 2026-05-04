<?php

namespace Modulos\Quinielas\Partidos\Actions;

use App\Livewire\Forms\Partidos\BuscarPartidosForm;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modulos\Quinielas\Models\PartidosSemana;
use Modulos\Quinielas\Partidos\Enums\BuscarPartidosFilterEnum;

class ListarPartidosAction
{
    public static function execute(BuscarPartidosForm $form)
    {
        try {
            $filters = collect($form->validate())
                ->map(function (mixed $value, string $key) {
                    return BuscarPartidosFilterEnum::from($key)->createFilter($value);
                })
                ->values()
                ->all();
            return app(Pipeline::class)
                ->send(PartidosSemana::query())
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
