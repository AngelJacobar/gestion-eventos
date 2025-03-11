@props(['id' => null, 'maxWidth' => null, 'type' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="bg-white ">
        <div class="">
            <div class=" text-center ">
                <div class="text-xl flex items-center justify-center font-semibold bg-primario-600 text-center text-white h-14">
                    {{ $title }}
                </div>

                @switch($type)
                @case('success')
                <div class="flex justify-center rounded-full mt-4">
                    <svg class="h-10 w-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                @break
                @case('question')
                <div class="flex justify-center rounded-full mt-4">
                    <svg class="h-10 w-10 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                      </svg>

                </div>

                @break

                @default
                <div class="flex justify-center rounded-full mt-4">
                    <svg class="h-10 w-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
            @endswitch
                <div class="mt-4 text-sm text-gray-600 mb-4 px-6 py-4">
                    {{ $content }}
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-row justify-center px-6 py-4 bg-cafe-50">
        {{ $footer }}
    </div>
</x-modal>
