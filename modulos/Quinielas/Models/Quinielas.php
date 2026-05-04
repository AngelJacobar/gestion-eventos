<?php

namespace Modulos\Quinielas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quinielas extends Model
{
    use HasFactory;

    protected $table = 'quinielas';
    protected $primaryKey = 'id_quiniela';

    protected $fillable = [
        'id_quiniela',
        'jornada',
        'nombre',
        'telefono',
        'pronostico_1',
        'pronostico_2',
        'pronostico_3',
        'pronostico_4',
        'pronostico_5',
        'pronostico_6',
        'pronostico_7',
        'pronostico_8',
        'pronostico_9',
        'puntaje_total',
        'estatus',
        'fecha_registro',
        'created_at',
        'updated_at',
    ];


}
