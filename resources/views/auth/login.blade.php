<x-guest-layout>
    <div class="marco w-11/12 sm:w-[340px] h-[320px] mx-auto">

         <!-- Session Status -->
        <x-auth-session-status  :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="h-24">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div  class="h-24">
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative mt-1 rounded-md shadow-sm"
                    x-data="{ showPass : false }">
                    <x-text-input id="password" class="block mt-1 w-full"
                    x-bind:type="showPass ? 'text':'password'"
                    name="password"
                    autocomplete="current-password" />
                    <div x-on:click="showPass = !showPass" class="absolute cursor-pointer top-1/2 right-4"
                        style="transform: translateY(-50%);">
                            <i class="text-gray-700 fa-sm fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'">
                        </i>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <x-captcha id="loginCaptcha" />

            <div class="text-center mt-2">

                <x-primary-button class="">
                    {{ __('Log in') }}
                </x-primary-button>

                @if (Route::has('password.request'))

                    <a class="block mt-5 text-sm " href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>

                @endif
            </div>
        </form>
    </div>

    @if (Route::has('idu'))
    <div class="marco w-11/12 sm:w-[340px] min-h-[100px] mx-auto text-center">

            <a href="{{ route('idu') }}" class="btn bg-teal-700 mt-2">
                {{ __('Ingresar con IDU') }}
            </a>
            <x-input-error :messages="$errors->get('idu')" class="mt-2" />
    </div>
    @endif
</x-guest-layout>

