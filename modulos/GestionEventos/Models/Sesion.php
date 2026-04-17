<?php

namespace Modulos\GestionEventos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modulos\GestionEventos\Models\Evento;

class Sesion extends Model
{
    use HasFactory;

    protected $table = 'sesion';
    protected $primaryKey = 'id_sesion';

    protected $fillable = [
        'nombre',
        'id_evento',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'ponente',
    ];

    /**
     * Relación con Evento
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }
}
