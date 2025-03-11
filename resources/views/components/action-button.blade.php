<button {{ $attributes->merge(['type' => 'button', 'class' => 'ico-table hover:bg-gray-700']) }}>
    {{ $slot }}
</button>
