<div>
    <div class="mx-auto md:min-h-[500px] sm:px-6 lg:px-8">
        <h1>
            {{ __('Eventos') }}
        </h1>
        
        <div class="mt-6">
            <div x-data="{ open: false }">
                <x-primary-button @click="open = !open" class="">
                    Criterios de búsqueda
                </x-primary-button>

                <div x-show="open" x-collapse.duration.500ms x-cloak>

                    <form wire:submit.prevent="filtrar()" class="marco">
                        <fieldset class="w-full grid grid-cols-12 gap-x-3">
                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm"
                                for="buscarEvento.nombre">
                                Nombre
                                <input type="text" id="buscarEvento.nombre" class="w-full" maxlength="50"
                                    wire:model="buscarEvento.nombre" placeholder="">
                                <div>
                                    @error('buscarEvento.nombre')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>
                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm"
                                for="buscarEvento.lugar">
                                Lugar
                                <input type="text" id="buscarEvento.lugar" class="w-full" maxlength="50"
                                    wire:model.live="buscarEvento.lugar" placeholder="">
                                <div>
                                    @error('buscarEvento.lugar')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>

                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm"
                                for="buscarEvento.fecha_inicio">
                                Fecha de inicio
                                <input type="date" id="buscarEvento.fecha_inicio" class="w-full"
                                    wire:model="buscarEvento.fecha_inicio">
                                <div>
                                    @error('buscarEvento.fecha_inicio')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>

                            </label>

                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm"
                                for="buscarEvento.fecha_fin">
                                Fecha de finalización
                                <input type="date" id="buscarEvento.fecha_fin" class="w-full"
                                    wire:model="buscarEvento.fecha_fin">
                                <div>
                                    @error('buscarEvento.fecha_fin')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>
                        </fieldset>
                        <div class="my-5 w-full flex justify-center text-center">
                            <x-primary-button class="mr-4" type="submit">
                                <svg wire:loading.delay wire:loading.attr="disabled" wire:target="filtrar"
                                    class="animate-spin -ml-1 mr-2 h-3 w-3 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Filtrar
                            </x-primary-button>
                            <x-secondary-button type="button" wire:click="restablecer">
                                <svg wire:loading.delay wire:loading.attr="disabled" wire:target="restablecer"
                                    class="animate-spin -ml-1 mr-2 h-3 w-3 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Limpiar
                            </x-secondary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="flex justify-between items-center content-center mt-5 mb-2">
            <div class="flex items-center text-sm">
                @if ($this->eventos->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif
                
            </div>
            <div class="flex justify-end items-center mt-5 mb-2"> <x-action-button
            class="bg-emerald-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
            wire:click="$dispatch('abrir-modal-registrar-evento', { idEvento: null })"> <i
                class="fa-solid fa-plus"></i> <span>Agregar</span> </x-action-button> </div>
        </div>
        @if (count($this->eventos) > 0)
            {{ $this->eventos->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="w-[25%]">
                                <div class="cursor-pointer" wire:click="order('nombre')">
                                    Nombre
                                    <span class="">@sortIcon('nombre', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[25%]">
                                <div class="cursor-pointer" wire:click="order('lugar')">
                                    Lugar
                                    <span class="">@sortIcon('lugar', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[12%]">
                                <div class="cursor-pointer" wire:click="order('fecha_inicio')">
                                    Fecha de inicio
                                    <span class="">@sortIcon('fecha_inicio', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[12%]">
                                <div class="cursor-pointer" wire:click="order('fecha_fin')">
                                    Fecha de finalización
                                    <span class="">@sortIcon('fecha_fin', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[8%]">
                                <div class="cursor-pointer" wire:click="order('capacidad')">
                                    Capacidad
                                    <span class="">@sortIcon('capacidad', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[8%]">
                                <div class="cursor-pointer" wire:click="order('activo')">
                                    Estado
                                    <span class="">@sortIcon('activo', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="text-centrado text-base">Acciones</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->eventos as $evento)
                            <tr>
                                <td class="text-centrado text-base">{{ $evento->nombre }}</td>
                                <td class="text-centrado text-base">{{ $evento->lugar }}</td>
                                <td class="text-centrado text-base">{{ $evento->fecha_inicio }}</td>
                                <td class="text-centrado text-base">{{ $evento->fecha_fin }}</td>
                                <td class="text-centrado text-base">{{ $evento->capacidad }}</td>
                                <td class="text-centrado text-base">{{ \App\Enums\EstatusEnum::from($evento->activo)->etiqueta() }}</td>
                                <td class="text-centrado text-base">
                                    <div class="flex gap-2 justify-center"> <x-action-button class="bg-sky-600 ml-3"
                                            data-tippy="Editar"
                                            wire:click="$dispatch('abrir-modal-registrar-evento', { idEvento: {{ $evento->id_evento }} })">
                                            <i class="fa-solid fa-pen-to-square"></i> </x-action-button>
                                        <x-action-button class="bg-red-600 ml-3" data-tippy="Eliminar"
                                            wire:click="$dispatch('abrir-modal-eliminar-evento', { idEvento: {{ $evento->id_evento }} })">
                                            <i class="fa-solid fa-trash"></i> </x-action-button> </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($this->eventos->count() >= 20)
                @if ($this->eventos->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif
                {{ $this->eventos->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            @endif
        @else
            <div class="alerta lg:w-[900px]">{{ $mensajeFiltrado }}</div>
        @endif

    </div>
    <livewire:eventos.registrar-evento-component />
    <livewire:eventos.eliminar-evento-component />
</div>
