<?php

namespace Modulos\Quinielas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quinielas72 extends Model
{
    use HasFactory;

    protected $table = 'quinielas_72';
    protected $primaryKey = 'id_quiniela_72';

    protected $fillable = [
        'id_quiniela_72',
        'jornada',
        'nombre',
        'telefono',
        'puntaje_total',
        'estatus',
        'fecha_registro',
        'created_at',
        'updated_at',
    ];

    /**
     * Relación con los detalles de pronósticos
     */
    public function detalles()
    {
        return $this->hasMany(QuinielasDetalle72::class, 'id_quiniela_72');
    }

    /**
     * Obtener detalles con información de partidos
     */
    public function detallesConPartidos()
    {
        return $this->detalles()->with('partido');
    }
}
