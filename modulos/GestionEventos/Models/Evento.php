<?php

namespace Modulos\GestionEventos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modulos\GestionEventos\Evento\QueryBuilders\EventoQueryBuilder;
use Modulos\GestionEventos\Models\Sesion;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'evento';
    protected $primaryKey = 'id_evento';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'lugar',
        'capacidad',
        'activo',
    ];

    /**
     * Relación con Sesiones
     */
    public function sesiones()
    {
        return $this->hasMany(Sesion::class, 'id_evento', 'id_evento');
    }

    public function asistentes_evento()
    {
        return $this->hasMany(AsistenteEvento::class, 'id_evento', 'id_evento');
    }

    public function newEloquentBuilder($query)
    {
        return new EventoQueryBuilder($query);
    }
}
