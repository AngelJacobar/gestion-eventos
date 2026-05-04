@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex justify-center w-full ps-3 pe-4 py-2 border-l-4 border-secundario-400 bg-white bg-opacity-20  text-start text-base font-medium text-white no-underline  focus:outline-none focus:text-secundario-800 focus:bg-secundario-100 focus:border-indigo-700  transition duration-150 ease-in-out'
            : 'flex justify-center w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white no-underline  hover:text-gray-800  hover:bg-white  hover:border-secundario-300 focus:outline-none focus:text-gray-800 focus:bg-white  focus:bg-opacity-10  transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
