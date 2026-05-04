<?php

namespace Modulos\Roles\Actions;

use App\Livewire\Forms\Roles\BuscarRolesForm;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modulos\Roles\Enums\BuscarRolesFilterEnum;
use Spatie\Permission\Models\Role;

class ListarRolesAction
{
    public static function execute(BuscarRolesForm $form)
    {
        try {
            $filters = collect($form->validate())
                ->map(function (mixed $value, string $key) {
                    return BuscarRolesFilterEnum::from($key)->createFilter($value);
                })
                ->values()
                ->all();
            return app(Pipeline::class)
                ->send(Role::select('id', 'name', 'guard_name', 'created_at', 'updated_at'))
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
