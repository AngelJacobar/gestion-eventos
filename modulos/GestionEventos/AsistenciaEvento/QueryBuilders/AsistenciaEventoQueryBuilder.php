<?php

namespace Modulos\GestionEventos\AsistenciaEvento\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class AsistenciaEventoQueryBuilder extends Builder
{
    public function buscar()
    {
        return $this
            ->select(
                'asistente_evento.id_asistente_evento',
                'evento.id_evento',
                'evento.nombre as nombre_evento',
                'usuario.id_usuario',
                'usuario.nombre as nombre_usuario',
                'usuario.primer_apellido',
                'usuario.segundo_apellido',
                'asistente_evento.fecha_registro',
                'asistente_evento.asistencia'
            )
            ->join('evento', 'evento.id_evento', '=', 'asistente_evento.id_evento')
            ->join('usuario', 'usuario.id_usuario', '=', 'asistente_evento.id_usuario')
        ;
    }
}
