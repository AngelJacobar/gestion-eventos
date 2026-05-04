<?php

namespace App\Enums;

enum RegistroTipoEnum
{
    case Usuario;
    case Rol;
    case Evento;
    case Sesion;
    case Partido;
    case Quiniela;

    public function registroTipo()
    {
        return match ($this) {
            self::Usuario => 'usuario',
            self::Rol => 'rol',
            self::Evento => 'evento',
            self::Sesion => 'sesion',
            self::Partido => 'partido',
            self::Quiniela => 'quiniela',
        };
    }

    public function descripcion()
    {
        return match ($this) {
            self::Usuario => 'Usuarios que tienen acceso al sistema.',
            self::Rol => 'Roles que se pueden asignar a los usuarios.',
            self::Evento => 'Eventos registrados en el sistema.',
            self::Sesion => 'Sesiones registradas en el sistema.',
            self::Partido => 'Partidos registrados en el sistema.',
            self::Quiniela => 'Quinielas registradas en el sistema.',
        };
    }
}
