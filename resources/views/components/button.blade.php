<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn']) }}  wire:loading.attr="disabled">
    {{ $slot }}
</button>
