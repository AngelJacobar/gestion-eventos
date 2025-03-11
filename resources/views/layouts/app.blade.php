<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="mt-6">
                    <h1>
                        {{ $header }}
                    </h1>
                </header>
            @endif

            <!-- Page Content -->
            <main class="w-11/12 mx-auto my-2 md:my-4 lg:my-8">
                {{ $slot }}
            </main>
            <footer class="w-full text-center text-xs border-t py-4">
                <p> UNAM {{ date('Y') }} </p>
                <p><a href="{{ route('creditos') }}">Créditos</a></p>
            </footer>
        </div>

        <livewire:extender-sesion-modal />

        {{--
            En cuanto se cumpla el tiempo de inactividad se recarga la pagina
            Como la sesión estará expirada se mostrará la pagina de login
        --}}
        <script>
            window.configTimer = {
                timeout: '{{ config('session.lifetime') }}'
            }
            document.addEventListener("DOMContentLoaded", function(event) {
                timer(window.configTimer)
            });
        </script>

        <x-toaster-hub />
        @stack('scripts')
        @livewireScripts
    </body>
</html>
