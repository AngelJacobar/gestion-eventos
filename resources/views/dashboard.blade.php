<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('Dashboard') }}
        </h1>
    </x-slot> 
    <div class="grid place-content-center md:min-h-[500px] text-xl overflow-hidden">
        <p class="">
            {{ __("You're logged in!") }}
        </p>
    </div>
</x-app-layout>
