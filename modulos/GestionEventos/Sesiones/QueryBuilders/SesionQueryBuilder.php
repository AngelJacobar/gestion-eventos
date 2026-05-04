<?php

namespace Modulos\GestionEventos\Sesiones\QueryBuilders;

use App\Enums\EstatusEnum;
use Illuminate\Database\Eloquent\Builder;

class SesionQueryBuilder extends Builder
{
    public function buscar()
    {
        return $this
            ->select(
                'sesion.id_sesion',
                'sesion.nombre',
                'sesion.id_evento',
                'sesion.fecha',
                'sesion.hora_inicio',
                'sesion.hora_fin',
                'sesion.ponente',
                'evento.nombre as nombre_evento',
                'sesion.activo'
            )
            ->join('evento', 'evento.id_evento', '=', 'sesion.id_evento')
            ->where('sesion.activo', EstatusEnum::Activo->value)
        ;
    }
}
