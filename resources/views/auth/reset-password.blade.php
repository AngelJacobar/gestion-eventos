<x-guest-layout>
<div class="marco w-11/12 sm:w-[340px] min-h-[320px]  mx-auto">
    <div class="mb-4 text-sm text-gray-600 ">
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email', $request->email)" autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative mt-1 rounded-md shadow-sm"
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

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
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

        <div class="flex items-center justify-center mt-5">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</div>
</div>
</x-guest-layout>


