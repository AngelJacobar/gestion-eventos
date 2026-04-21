<?php

namespace App\Enums;

enum RegistroTipoEnum
{
    case Usuario;
    case Rol;
    case Evento;
    case Sesion;

    public function registroTipo()
    {
        return match ($this) {
            self::Usuario => 'usuario',
            self::Rol => 'rol',
            self::Evento => 'evento',
            self::Sesion => 'sesion',
        };
    }

    public function descripcion()
    {
        return match ($this) {
            self::Usuario => 'Usuarios que tienen acceso al sistema.',
            self::Rol => 'Roles que se pueden asignar a los usuarios.',
            self::Evento => 'Eventos registrados en el sistema.',
            self::Sesion => 'Sesiones registradas en el sistema.',
        };
    }
}
