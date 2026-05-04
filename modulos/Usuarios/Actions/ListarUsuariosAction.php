<?php

namespace Modulos\Usuarios\Actions;

use App\Livewire\Forms\Usuarios\BuscarUsuariosForm;
use App\Models\Usuario;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modulos\Usuarios\Enums\BuscarUsuariosFilterEnum;

class ListarUsuariosAction
{
    public static function execute(BuscarUsuariosForm $form)
    {
        try {
            $filters = collect($form->validate())
                ->map(function (mixed $value, string $key) {
                    return BuscarUsuariosFilterEnum::from($key)->createFilter($value);
                })
                ->values()
                ->all();
            return app(Pipeline::class)
                ->send(Usuario::buscar())
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
