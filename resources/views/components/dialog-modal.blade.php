@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="">
        <div class="text-xl flex items-center justify-center font-semibold bg-primario-600 text-center text-white h-14">
            {{ $title }}
        </div>

        <div class="mt-4 text-sm text-gray-600 px-5 pb-5">
            {{ $content }}
        </div>
    </div>

    <div class="flex justify-center px-6 py-4 bg-cafe-50 text-right">
        {{ $footer }}
    </div>
</x-modal>
