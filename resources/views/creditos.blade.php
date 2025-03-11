@auth
    <x-app-layout>
        <x-slot name="header">
            <h1>
                {{ __('Creditos') }}
            </h1>
        </x-slot>
        <x-creditos/>
    </x-app-layout>
@endauth

@guest
    <x-guest-layout>
        <div class="bg-white w-full py-5">
            <h1>
                {{ __('Creditos') }}
            </h1>
            <x-creditos/>
        </div>
    </x-guest-layout>
@endguest
