<?php

namespace App\Traits;

trait WithLiveValidation
{
    /**
     * Realiza la validación en tiempo real de los campos del formulario,
     * conservando la validación de los campos con errores.
     *
     * En el componente Livewire que utilice este trait debe existir una propiedad
     * llamada $formName que contenga el nombre del formulario que se va a validar.
     *
     * @param [type] $propertyName
     * @param [type] $value
     *
     * @return void
     */
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function updatedWithLiveValidation($propertyName, $value)
    {
        if (! str_starts_with($propertyName, $this->formName . '.')) {
            return;
        }

        //Se valida el campo que se modificó y los campos con errores
        $camposValidar = $this->getErrorBag()->keys();
        $camposValidar[] = $propertyName;

        $camposValidar = array_map(function ($campo) {
            $campo = str_replace($this->formName . '.', '', $campo);
            return preg_replace('/\.\d+$/', '', $campo);
        }, $camposValidar);

        //Obtener las rules de los campos a validar
        $rules = $this->{$this->formName}->rules();
        $rules = array_intersect_key($rules, array_flip($camposValidar));

        if (count($rules) == 0) {
            return;
        }

        $this->{$this->formName}->validate($rules);
    }
}
