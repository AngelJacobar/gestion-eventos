<div>
    <div class="mx-auto md:min-h-[500px] sm:px-6 lg:px-8">
        <h1>
            {{ __('Asistencia') }}
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
                                for="buscarAsistenciaEvento.id_evento">
                                Evento
                                <select id="buscarAsistenciaEvento.id_evento"
                                    wire:model="buscarAsistenciaEvento.id_evento" class="w-full border p-2">
                                    <option value="">Seleccione un evento</option>
                                    @foreach ($this->eventos as $evento)
                                        <option value="{{ $evento->id_evento }}">{{ $evento->nombre }}</option>
                                    @endforeach
                                </select>

                                <div>
                                    @error('buscarAsistenciaEvento.id_evento')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>
                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm"
                                for="buscarAsistenciaEvento.fecha_registro">
                                Fecha de registro al evento
                                <input type="date" id="buscarAsistenciaEvento.fecha_registro" class="w-full"
                                    wire:model="buscarAsistenciaEvento.fecha_registro">
                                <div>
                                    @error('buscarAsistenciaEvento.fecha_registro')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>

                            </label>
                            @if (auth()->user()->hasRole('administrador') || auth()->user()->hasRole('Organizador'))
                                <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm"
                                    for="buscarAsistenciaEvento.id_usuario">
                                    Usuario
                                    <select id="buscarAsistenciaEvento.id_usuario"
                                        wire:model="buscarAsistenciaEvento.id_usuario" class="w-full border p-2">
                                        <option value="">Seleccione un usuario</option>
                                        @foreach ($this->usuarios as $usuario)
                                            <option value="{{ $usuario->id_usuario }}">{{ $usuario->nombre }}
                                                {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error('buscarAsistenciaEvento.id_usuario')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </label>
                            @endif

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
                 @if ($this->asistencias->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif 

            </div>
            <div class="flex justify-end items-center mt-5 mb-2"> <x-action-button
                    class="bg-emerald-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="$dispatch('abrir-modal-registrar-asistencia-evento', { idAsistenciaEvento: null })"> <i
                        class="fa-solid fa-plus"></i> <span>Agregar</span> </x-action-button> </div>
        </div>
        @if (count($this->asistencias) > 0)
            {{ $this->asistencias->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="w-[30%] text-center">
                                <div class="cursor-pointer" wire:click="order('nombre')">
                                    Evento
                                    <span class="">@sortIcon('nombre', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[30%] text-center">
                                <div class="cursor-pointer" wire:click="order('lugar')">
                                    Usuario
                                    <span class="">@sortIcon('lugar', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[30%] text-center">
                                <div class="cursor-pointer" wire:click="order('fecha_inicio')">
                                    Fecha de registro
                                    <span class="">@sortIcon('fecha_inicio', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[10%] text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->asistencias as $asistencia)
                            <tr>
                                <td class="text-center text-base">{{ $asistencia->nombre_evento }}</td>
                                <td class="text-center text-base">{{ $asistencia->nombre_usuario }}
                                    {{ $asistencia->primer_apellido }} {{ $asistencia->segundo_apellido }}</td>
                                <td class="text-center text-base">{{ $asistencia->fecha_registro }}</td>
                                <td class="text-center text-base">
                                    <div class="flex gap-2 justify-center"> <x-action-button class="bg-sky-600 ml-3"
                                            data-tippy="Editar"
                                            wire:click="$dispatch('abrir-modal-registrar-asistencia-evento', { idAsistenciaEvento: {{ $asistencia->id_asistente_evento }} })">
                                            <i class="fa-solid fa-pen-to-square"></i> </x-action-button>
                                        <x-action-button class="bg-red-600 ml-3" data-tippy="Eliminar"
                                            wire:click="$dispatch('abrir-modal-eliminar-asistencia-evento', { idAsistenciaEvento: {{ $asistencia->id_asistente_evento }} })">
                                            <i class="fa-solid fa-trash"></i> </x-action-button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
             @if ($this->asistencias->count() >= 20)
                @if ($this->asistencias->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif
                {{ $this->asistencias->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            @endif 
        @else
            <div class="alerta lg:w-[900px]">{{ $mensajeFiltrado }}</div>
        @endif

    </div>
    <livewire:asistencia-evento.registrar-asistencia-evento-component /> 
    <livewire:asistencia-evento.eliminar-asistencia-evento-component />
</div>
