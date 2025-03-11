<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gradient-to-t  from-primario-400 to-primario-600 ">

            <div class="relative min-h-screen flex flex-col items-center justify-center ">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="flex flex-col items-center">
                        <a href="http://www.unam.mx" target="_blank" class="my-3">
                            <x-application-logo/>
                        </a>
                    </header>

                    <main>
                        <nav class="marco grid place-content-center gap-5 w-11/12 sm:w-[340px] h-[320px] mx-auto">
                        @auth
                            <a href="{{ url('/inicio') }}" class="btn">
                                {{ __('Dashboard') }}
                            </a>
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="btn bg-primario-900">
                                    {{ __('Log in') }}
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn bg-emerald-800">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @endauth
                        </nav>
                    </main>

                    <footer class="py-16">
                        <p class="text-center text-sm text-white"> UNAM {{ date('Y') }} </p>
                        <p class="text-center"><a href="{{ route('creditos') }}"  class=" text-sm text-white">Créditos</a></p>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
