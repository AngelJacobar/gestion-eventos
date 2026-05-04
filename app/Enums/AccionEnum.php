<?php

namespace App\Enums;

enum AccionEnum: string
{
    case Registro = '1';
    case Modificacion = '2';
    case Eliminacion = '3';
    case InicioSesion = '4';
    case CierreSesion = '5';
    case CambioContrasena = '6';
    case RecuperacionContrasena = '7';
    case CambiarEstatus = '8';
}
