<?php

namespace Modulos\GestionEventos\AsistenciaEvento\Enums;

enum AsistenciaEnum :string
{
    case Asistio = 'S';
    case NoAsistio = 'N';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Asistio => 'Asistió',
            self::NoAsistio => 'No Asistió'
        };
    }

    public function value(): string
    {
        return match ($this) {
            self::Asistio => 'S',
            self::NoAsistio => 'N'
        };
    }
}
