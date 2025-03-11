<?php

namespace App\Traits;

trait WithColumnFiltering
{
    public $mensajeFiltrado = 'No se encontraron resultados';

    /**
     * $filtrosAplicados debe definirse en el componente que use este trait
     */
    // public $filtrosAplicados;

    public function actualizarMensajeFiltrado()
    {
        if (count(array_filter($this->filtrosAplicados->toArray())) > 0) {
            $this->mensajeFiltrado = 'No se encontraron resultados que coincidan con los criterios proporcionados';
        } else {
            $this->reset('mensajeFiltrado');
        }
    }
}
