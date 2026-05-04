<?php

namespace Modulos\GestionEventos\Roles\Enums;



enum RolesEnum: string
{
    case administrador = '1';
    case Invitado = '2';
    case Asistente = '3';
    case Organizador = '4';
}