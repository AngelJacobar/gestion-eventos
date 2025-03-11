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
        <div class="min-h-screen flex flex-col sm:justify-center items-center bg-gradient-to-t from-primario-400 to-primario-600 ">
            <div class="my-3">
                <a href="http://www.unam.mx" target="_blank">
                    <x-application-logo/>
                </a>
            </div>
            <main>
                {{ $slot }}
            </main>
            <footer class="py-16">
                <p class="text-center text-sm text-white"> UNAM {{ date('Y') }} </p>
                <p class="text-center"><a href="{{ route('creditos') }}"  class=" text-sm text-white">Créditos</a></p>
            </footer>
        </div>
        @if (config('services.recaptcha.enable'))
        <script src="https://www.google.com/recaptcha/api.js?onload=handleRecaptchaLoad&render=explicit" async defer></script>
        <script class="grecaptcha">
            let captchaIds = ['loginCaptcha']
            function handleRecaptchaLoad() {
                captchaIds.forEach((captchaId, key) => {
                    if (!document.getElementById(captchaId)) {
                        return
                    }

                    window[`widget_captcha${key}`] = grecaptcha.render(
                        captchaId, {
                            'sitekey': '{{ config('services.recaptcha.site_key') }}'
                        }
                    )
                })
            }
            window.addEventListener('reset-google-recaptcha', () => {
                captchaIds.forEach((captchaId, key) => {
                    if (!document.getElementById(captchaId)) {
                        return
                    }

                    grecaptcha.reset(window[`widget_captcha${key}`], {
                        'sitekey': '{{ config('services.recaptcha.site_key') }}'
                    })
                })
            })
        </script>
        @endif
        {{--
            En cuanto se cumpla el tiempo de inactividad se recarga la pagina
            En el caso de layout guest esto se agrega para evitar el error 419 al intentar usar el formulario de login
            después de que el token haya expirado
        --}}
        <script>
            window.configTimer = {
                timeout: '{{ config('session.lifetime') }}',
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
