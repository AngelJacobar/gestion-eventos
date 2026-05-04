<?php

namespace App\Models;

use App\QueryBuilders\BitacoraQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $table = 'bitacora';
    protected $primaryKey = 'id_bitacora';
    protected $fillable = [
        'id_accion',
        'descripcion',
        'fecha_hora',
        'registro_tipo',
        'registro_id',
        'id_usuario',
    ];

    public function newEloquentBuilder($query)
    {
        return new BitacoraQueryBuilder($query);
    }
}
