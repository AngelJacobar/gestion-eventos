<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('Cambiar contraseña') }}
        </h1>
    </x-slot>

    <div class="">
        <div class="w-11/12 sm:w-8/12 md:w-[400px] mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
