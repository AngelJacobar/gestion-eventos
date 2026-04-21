<?php

namespace Modulos\GestionEventos\Models;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modulos\GestionEventos\AsistenciaEvento\QueryBuilders\AsistenciaEventoQueryBuilder;
use Modulos\GestionEventos\Models\Sesion;

class AsistenteEvento extends Model
{
    use HasFactory;

    protected $table = 'asistente_evento';
    protected $primaryKey = 'id_asistente_evento';

    protected $fillable = [
        'id_evento',
        'id_usuario',
        'fecha_registro',
        'asistencia',
    ];

    /**
     * Relación con Sesiones
     */
    public function evento()
    {
        return $this->belongsTo(Sesion::class, 'id_evento', 'id_evento');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function newEloquentBuilder($query)
    {
        return new AsistenciaEventoQueryBuilder($query);
    }
}
