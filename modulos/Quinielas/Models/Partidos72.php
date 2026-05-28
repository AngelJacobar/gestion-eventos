<?php

namespace Modulos\Quinielas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partidos72 extends Model
{
    use HasFactory;

    protected $table = 'partidos_72';
    protected $primaryKey = 'id_partido_72';

    protected $fillable = [
        'id_partido_72',
        'numero_partido',
        'equipo_local',
        'equipo_visitante',
        'resultado',
        'created_at',
        'updated_at',
    ];

    /**
     * Relación con los detalles de quinielas
     */
    public function detallesQuinielas()
    {
        return $this->hasMany(QuinielasDetalle72::class, 'id_partido_72');
    }
}
