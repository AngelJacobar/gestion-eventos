<?php

namespace App\Models;

use App\Enums\EstatusEnum;
use App\QueryBuilders\UsuarioQueryBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'activo',
        'email',
        'curp',
        'numero_cuenta',
        'numero_trabajador',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: function () {
                return trim(trim($this->nombre ?? '') . ' '
                . trim($this->primer_apellido ?? '') . ' '
                . trim($this->segundo_apellido ?? ''));
            }
        );
    }

    public function newEloquentBuilder($query)
    {
        return new UsuarioQueryBuilder($query);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => EstatusEnum::class,
        ];
    }
}
