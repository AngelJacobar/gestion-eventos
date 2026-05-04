@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 pt-1 border-b-4 border-secundario-100 no-underline text-sm font-semibold leading-5 text-white        hover:text-white transition duration-150 ease-in-outb bg-white bg-opacity-20 focus:outline-none focus:outline-none focus:ring-none focus:ring-offset-none focus:bg-white focus:bg-opacity-30'
            : 'inline-flex items-center px-3 pt-1 border-b-4 border-transparent    no-underline text-sm font-semibold leading-5 text-primario-100 hover:text-secundario-100 hover:border-secundario-200 transition duration-150 ease-in-out focus:outline-none  focus:bg-white focus:bg-opacity-30 focus:border-secundario-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
