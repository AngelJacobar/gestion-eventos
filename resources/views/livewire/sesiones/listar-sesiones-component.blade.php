<div>
    <div class="mx-auto md:min-h-[500px] sm:px-6 lg:px-8">
        <h1>
            {{ __('Sesiones') }}
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
                                for="buscarSesion.nombre">
                                Nombre de la sesión
                                <input type="text" id="buscarSesion.nombre" class="w-full" maxlength="50"
                                    wire:model="buscarSesion.nombre" placeholder="">
                                <div>
                                    @error('buscarSesion.nombre')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>
                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm"
                                for="buscarSesion.ponente">
                                Ponente de la sesión
                                <input type="text" id="buscarSesion.ponente" class="w-full" maxlength="50"
                                    wire:model="buscarSesion.ponente" placeholder="">
                                <div>
                                    @error('buscarSesion.ponente')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>
                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm"
                                for="buscarSesion.id_evento">
                                Evento
                                <select id="buscarSesion.id_evento" wire:model="buscarSesion.id_evento"
                                    class="w-full border p-2">
                                    <option value="">Seleccione un evento</option>
                                    @foreach ($this->eventos as $evento)
                                        <option value="{{ $evento->id_evento }}">{{ $evento->nombre }}</option>
                                    @endforeach
                                </select>

                                <div>
                                    @error('buscarSesion.id_evento')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>
                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm"
                                for="buscarSesion.fecha">
                                Fecha de la sesión
                                <input type="date" id="buscarSesion.fecha" class="w-full"
                                    wire:model="buscarSesion.fecha">
                                <div>
                                    @error('buscarSesion.fecha')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>

                            </label>

                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm"
                                for="buscarSesion.hora_inicio">
                                Hora de inicio
                                <input type="time" id="buscarSesion.hora_inicio" class="w-full"
                                    wire:model="buscarSesion.hora_inicio">
                                <div>
                                    @error('buscarSesion.hora_inicio')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>

                            </label>

                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm"
                                for="buscarSesion.hora_fin">
                                Hora de finalización
                                <input type="time" id="buscarSesion.hora_fin" class="w-full"
                                    wire:model="buscarSesion.hora_fin">
                                <div>
                                    @error('buscarSesion.hora_fin')
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
                @if ($this->sesiones->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif

            </div>
            <div class="flex justify-end items-center mt-5 mb-2"> <x-action-button
                    class="bg-emerald-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="$dispatch('abrir-modal-registrar-sesion', { idSesion: null })"> <i
                        class="fa-solid fa-plus"></i> <span>Agregar</span> </x-action-button> </div>
        </div>
        @if (count($this->sesiones) > 0)
            {{ $this->sesiones->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="w-[25%]">
                                <div class="cursor-pointer" wire:click="order('nombre_evento')">
                                    Evento
                                    <span class="">@sortIcon('nombre_evento', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[25%]">
                                <div class="cursor-pointer" wire:click="order('nombre')">
                                    Nombre
                                    <span class="">@sortIcon('nombre', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[25%]">
                                <div class="cursor-pointer" wire:click="order('ponente')">
                                    Ponente
                                    <span class="">@sortIcon('ponente', $sort, $direction)</span>
                                </div>
                            </th>

                            <th class="w-[7%]">
                                <div class="cursor-pointer" wire:click="order('fecha')">
                                    Fecha
                                    <span class="">@sortIcon('fecha', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[8%]">
                                <div class="cursor-pointer" wire:click="order('hora_inicio')">
                                    Hora de inicio
                                    <span class="">@sortIcon('hora_inicio', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[8%]">
                                <div class="cursor-pointer" wire:click="order('hora_fin')">
                                    Hora de fin
                                    <span class="">@sortIcon('hora_fin', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[17%]">
                                <div class="cursor-pointer" wire:click="order('activo')">
                                    Estado
                                    <span class="">@sortIcon('activo', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="text-centrado text-base">Acciones</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->sesiones as $sesion)
                            <tr>
                                <td class="text-centrado text-base">{{ $sesion->nombre_evento }}</td>
                                <td class="text-centrado text-base">{{ $sesion->nombre }}</td>
                                <td class="text-centrado text-base">{{ $sesion->ponente }}</td>
                                <td class="text-centrado text-base">{{ $sesion->fecha }}</td>
                                <td class="text-centrado text-base">{{ $sesion->hora_inicio }}</td>
                                <td class="text-centrado text-base">{{ $sesion->hora_fin }}</td>
                                <td class="text-centrado text-base">
                                    {{ \App\Enums\EstatusEnum::from($sesion->activo)->etiqueta() }}</td>
                                <td class="text-centrado text-base">
                                    <div class="flex gap-2 justify-center"> <x-action-button class="bg-sky-600 ml-3"
                                            data-tippy="Editar"
                                            wire:click="$dispatch('abrir-modal-registrar-sesion', { idSesion: {{ $sesion->id_sesion }} })">
                                            <i class="fa-solid fa-pen-to-square"></i> </x-action-button>
                                        <x-action-button class="bg-red-600 ml-3" data-tippy="Eliminar"
                                            wire:click="$dispatch('abrir-modal-eliminar-sesion', { idSesion: {{ $sesion->id_sesion }} })">
                                            <i class="fa-solid fa-trash"></i> </x-action-button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($this->sesiones->count() >= 20)
                @if ($this->sesiones->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif
                {{ $this->sesiones->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            @endif
        @else
            <div class="alerta lg:w-[900px]">{{ $mensajeFiltrado }}</div>
        @endif

    </div>
        <livewire:sesiones.registrar-sesion-component />
        <livewire:sesiones.eliminar-sesion-component />
</div>
