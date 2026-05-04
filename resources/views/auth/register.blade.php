<x-guest-layout>
<div class="marco w-11/12 sm:w-[400px]  mx-auto">
    <p class="text-2xl text-center font-bold mb-5">Registrar usuario</p>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="h-[90px]">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" autofocus autocomplete="nombre" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-1" />
        </div>

        <!-- Last Name -->
        <div class="h-[90px]">
            <x-input-label for="primer_apellido" :value="__('Primer apellido')" />
            <x-text-input id="primer_apellido" class="block mt-1 w-full" type="text" name="primer_apellido" :value="old('primer_apellido')" autocomplete="primer_apellido" />
            <x-input-error :messages="$errors->get('primer_apellido')" class="mt-1" />
        </div>

        <!-- Second Last Name -->
        <div class="h-[90px]">
            <x-input-label for="segundo_apellido" :value="__('Segundo apellido')" />
            <x-text-input id="segundo_apellido" class="block mt-1 w-full" type="text" name="segundo_apellido" :value="old('segundo_apellido')" autocomplete="segundo_apellido" />
            <x-input-error :messages="$errors->get('segundo_apellido')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div class="h-[90px]">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="min-h-[90px]">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative  rounded-md shadow-sm"
                x-data="{ showPass : false }">
                <x-text-input id="password" class="block mt-1 w-full"
                x-bind:type="showPass ? 'text':'password'"
                name="password"
                autocomplete="new-password"
                maxlength="15" />
                <div x-on:click="showPass = !showPass" class="absolute cursor-pointer top-1/2 right-4"
                    style="transform: translateY(-50%);">
                        <i class="text-gray-700 fa-sm fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'">
                    </i>
                </div>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <div class="relative mt-1 rounded-md shadow-sm"
                x-data="{ showPass : false }">
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                x-bind:type="showPass ? 'text':'password'"
                name="password_confirmation"
                autocomplete="new-password"
                maxlength="15" />
                <div x-on:click="showPass = !showPass" class="absolute cursor-pointer top-1/2 right-4"
                    style="transform: translateY(-50%);">
                        <i class="text-gray-700 fa-sm fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'">
                    </i>
                </div>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <x-captcha id="loginCaptcha" />
        <div class="flex flex-col items-center justify-center mt-4">
            <x-primary-button class="my-4">
                {{ __('Register') }}
            </x-primary-button>
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
</div>
</x-guest-layout>
