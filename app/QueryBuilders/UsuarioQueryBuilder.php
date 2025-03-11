<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class UsuarioQueryBuilder extends Builder
{
    public function buscar()
    {
        return $this
            ->select(
                'usuario.id_usuario',
                'usuario.nombre',
                'usuario.primer_apellido',
                'usuario.segundo_apellido',
                'usuario.email',
                'model_has_roles.role_id',
                'roles.name as rol',
                'usuario.activo',
            )
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'usuario.id_usuario')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')

        ;
    }
}
