<?php

namespace App\Enums;

enum EstatusEnum :string
{
    case Activo = 'S';
    case Inactivo = 'N';
    case Pendiente = 'P';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Activo => 'Activo',
            self::Inactivo => 'Inactivo',
            self::Pendiente => 'Pendiente',
        };
    }

    public function value(): bool
    {
        return match ($this) {
            self::Activo => 'S',
            self::Inactivo => 'N',
            self::Pendiente => 'P',
            

        };
    }
}
