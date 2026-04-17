<?php

namespace Modulos\GestionEventos\Evento\QueryBuilders;

use App\Enums\EstatusEnum;
use Illuminate\Database\Eloquent\Builder;

class EventoQueryBuilder extends Builder
{
    public function buscar()
    {
        return $this
            ->select(
                'evento.id_evento',
                'evento.nombre',
                'evento.lugar',
                'evento.fecha_inicio',
                'evento.fecha_fin',
                'evento.capacidad',
                'evento.activo'
            )
                    ->where('evento.activo', EstatusEnum::Activo->value)
        ;
    }
}
