<?php

namespace Modulos\Quinielas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuinielasDetalle72 extends Model
{
    use HasFactory;

    protected $table = 'quinielas_detalle_72';
    protected $primaryKey = 'id_detalle_72';

    protected $fillable = [
        'id_detalle_72',
        'id_quiniela_72',
        'id_partido_72',
        'pronostico',
        'acierto',
        'created_at',
        'updated_at',
    ];

    /**
     * Relación con la quiniela
     */
    public function quiniela()
    {
        return $this->belongsTo(Quinielas72::class, 'id_quiniela_72');
    }

    /**
     * Relación con el partido
     */
    public function partido()
    {
        return $this->belongsTo(Partidos72::class, 'id_partido_72');
    }
}
