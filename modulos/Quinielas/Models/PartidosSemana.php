<?php

namespace Modulos\Quinielas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartidosSemana extends Model
{
    use HasFactory;

    protected $table = 'partidos_semana';
    protected $primaryKey = 'id_partido';

    protected $fillable = [
        'id_partido',
        'jornada',
        'numero_partido',
        'equipo_local',
        'equipo_visitante',
        'fecha_partido',
        'resultado',
        'estatus',
        'fecha_inicio_jornada',
        'fecha_fin_jornada',
        'created_at',
        'updated_at',
    ];


}
