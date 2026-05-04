<?php

namespace Modulos\GestionEventos\Evento\Actions;

use App\Livewire\Forms\Eventos\BuscarEventosForm;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modulos\GestionEventos\Evento\Enums\BuscarEventosFilterEnum;
use Modulos\GestionEventos\Models\Evento;

class ListarEventosAction
{
    public static function execute(BuscarEventosForm $form)
    {
        try {
            $filters = collect($form->validate())
                ->map(function (mixed $value, string $key) {
                    return BuscarEventosFilterEnum::from($key)->createFilter($value);
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

// filters= collect($form->validate())->map(fn(mixed $value, string $key) => BuscarEventosFilterEnum::from($key)->createFilter($value))->values()->all();
/**
 * se usa collect() para crear una colección a partir de los datos validados del formulario, es decir,
 * se toma el resultado de $form->validate() y se convierte en una colección de Laravel para facilitar su manipulación.
 * form->validate() se encarga de validar los datos del formulario según las reglas definidas en BuscarEventosForm, y 
 * devuelve un array con los datos validados.
 * Luego, se utiliza map() para iterar sobre cada par clave-valor del array validado, 
 * donde $key representa el nombre del campo (por ejemplo, 'nombre', 'lugar', etc.) y $value representa el valor ingresado por el usuario.
 * Dentro del map(), se utiliza BuscarEventosFilterEnum::from($key) para obtener la instancia del enum correspondiente al nombre del campo,
 * y luego se llama al método createFilter($value) para crear una instancia del filtro correspondiente con el valor proporcionado por el usuario.
 * Finalmente, se llama a values() para obtener solo los valores de la colección (sin las claves) y all() para convertir la colección resultante en
 * un array de filtros que se aplicarán a la consulta de eventos.
 * 
 * return app(Pipeline::class)->send(Evento::buscar())->through($filters)->thenReturn();
 * Aqui se utiliza el patrón Pipeline para aplicar una serie de filtros a la consulta de eventos.
 * Pipeline::class se utiliza para crear una instancia del pipeline, pipeline es un patrón de diseño que permite encadenar una serie de operaciones 
 * (en este caso, filtros) de manera fluida.Con el objetivo de aplicar los filtros a la consulta de eventos,
 *  se envía la consulta inicial (Evento::buscar()) al pipeline utilizando send(),
 * luego se especifica que los filtros deben ser aplicados a través del método through($filters),
 *  y finalmente se obtiene el resultado con thenReturn().
 */