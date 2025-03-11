<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Modulo de usuarios
    |--------------------------------------------------------------------------
    |
    | Mensajes de notificacion para el módulo de usuarios
    |
    */

    'registro' => [
        'exito' => 'El usuario se ha registrado.',
        'error' => 'Ocurrió un error al registrar la información del usuario.',
    ],
    'edicion' => [
        'exito' => 'El usuario se ha actualizado.',
        'error' => 'Ocurrió un error al modificar la información del usuario.',
    ],
    'estatus' => [
        'activacion' => 'El usuario queda como activo, con acceso al sistema.',
        'desactivacion' => 'El usuario queda como inactivo, sin acceso al sistema.',
        'error' => 'Ocurrió un problema al cambiar el estatus del usuario.',
        'cierre_sesion' => 'Su sesión se cerrará debido a que su cuenta de usuario fue desactivada.',
        'confirmar_activacion' => 'Al confirmar, el usuario podrá acceder al sistema. ¿Desea continuar?',
        'confirmar_desactivacion' => 'Al confirmar, el usuario ya no podrá acceder al sistema. ¿Desea continuar?',
        'confirmar_desactivacion_propia' => 'Al confirmar, usted ya no podrá acceder al sistema. ¿Está seguro que desea continuar?',
    ],

];
