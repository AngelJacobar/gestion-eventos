<?php

namespace App\Enums;

enum EstatusEnum :string
{
    case Activo = 'S';
    case Inactivo = 'N';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Activo => 'Activo',
            self::Inactivo => 'Inactivo'
        };
    }

    public function value(): bool
    {
        return match ($this) {
            self::Activo => 'S',
            self::Inactivo => 'N'
        };
    }
}
