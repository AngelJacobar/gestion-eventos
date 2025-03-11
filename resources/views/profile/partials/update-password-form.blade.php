<section>
    <header>
        <p class="text-sm text-center text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="relative mt-1 rounded-md shadow-sm" x-data="{ showPass : false }">
                <x-text-input
                    id="update_password_current_password"
                    class="block mt-1 w-full"
                    x-bind:type="showPass ? 'text':'password'"
                    name="current_password"
                    autocomplete="current-password"
                    maxlength="15" />
                    <div x-on:click="showPass = !showPass"
                        class="absolute cursor-pointer top-1/2 right-4"
                        style="transform: translateY(-50%);">
                            <i class="text-gray-700 fa-sm fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="relative mt-1 rounded-md shadow-sm" x-data="{ showPass : false }">
                    <x-text-input
                    id="update_password_password"
                    class="block mt-1 w-full"
                    x-bind:type="showPass ? 'text':'password'"
                    name="password"
                    autocomplete="new-password"
                    maxlength="15" />
                    <div x-on:click="showPass = !showPass" class="absolute cursor-pointer top-1/2 right-4"
                        style="transform: translateY(-50%);">
                            <i class="text-gray-700 fa-sm fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="relative mt-1 rounded-md shadow-sm" x-data="{ showPass : false }">
                    <x-text-input
                    id="update_password_password_confirmation"
                    class="block mt-1 w-full"
                    x-bind:type="showPass ? 'text':'password'"
                    name="password_confirmation"
                    autocomplete="new-password"
                    maxlength="15" />
                    <div x-on:click="showPass = !showPass" class="absolute cursor-pointer top-1/2 right-4"
                        style="transform: translateY(-50%);">
                            <i class="text-gray-700 fa-sm fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex justify-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
