<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-1 rounded-md shadow-sm"
                x-data="{ showPass : false }">
                <x-text-input id="password" class="block mt-1 w-full"
                x-bind:type="showPass ? 'text':'password'"
                name="password"
                autocomplete="current-password"
                maxlength="15" />
                <div x-on:click="showPass = !showPass" class="absolute cursor-pointer top-1/2 right-4"
                    style="transform: translateY(-50%);">
                        <i class="text-gray-700 fa-sm fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'">
                    </i>
                </div>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
