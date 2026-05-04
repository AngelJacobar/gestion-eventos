<x-mail::message>
{{-- Greeting --}}
# Hola {{ $nombre }},


{{-- Intro Lines --}}

Nos es grato informarle que su cuenta de acceso ha sido creada. Para acceder por primera vez, realice los siguientes pasos:

1.  Se le enviará un correo con las indicaciones para restablecer contraseña.
2.  Una vez que cuente con la contraseña puede ingresar al siguiente enlace:
    [Sistema {{ config('app.name') }}]({{ route('login') }})
    con sus datos de acceso.

Gracias,

Administrador del Sistema "{{ config('app.name') }}"

</x-mail::message>
