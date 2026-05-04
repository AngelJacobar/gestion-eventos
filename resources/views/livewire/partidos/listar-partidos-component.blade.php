<div>
    <div class="mx-auto md:min-h-[500px] sm:px-6 lg:px-8">
        <h1>
            {{ __('Partidos') }}
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
                                for="buscarPartido.estatus">
                                Estatus
                                <select id="buscarPartido.estatus"
                                    wire:model="buscarPartido.estatus" class="w-full border p-2">
                                    <option value="">Seleccione un estatus</option>
                                    @foreach ($this->estatus as $estatus)
                                        <option value="{{ $estatus->estatus }}">{{ \App\Enums\EstatusEnum::from($estatus->estatus)->etiqueta() }}</option>
                                    @endforeach
                                </select>

                                <div>
                                    @error('buscarPartido.estatus')
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
            {{-- <div class="flex items-center text-sm">
                @if ($this->partidos->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif
                
            </div> --}}
            <div class="flex justify-end items-center mt-5 mb-2"> <x-action-button
            class="bg-emerald-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
            wire:click="$dispatch('abrir-modal-registrar-partido', { idPartido: null })"> <i
                class="fa-solid fa-plus"></i> <span>Agregar</span> </x-action-button> </div>
        </div>
        @if (count($this->partidos) > 0)
            {{ $this->partidos->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="w-[10%]">
                                <div class="cursor-pointer" wire:click="order('jornada')">
                                    Jornada
                                    <span class="">@sortIcon('jornada', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[10%]">
                                <div class="cursor-pointer" wire:click="order('numero_partido')">
                                    No. Partido
                                    <span class="">@sortIcon('numero_partido', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[12%]">
                                <div class="cursor-pointer" wire:click="order('equipo_local')">
                                    Local
                                    <span class="">@sortIcon('equipo_local', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[12%]">
                                <div class="cursor-pointer" wire:click="order('equipo_visitante')">
                                    Visitante
                                    <span class="">@sortIcon('equipo_visitante', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[8%]">
                                <div class="cursor-pointer" wire:click="order('fecha_partido')">
                                    Fecha
                                    <span class="">@sortIcon('fecha_partido', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[8%]">
                                <div class="cursor-pointer" wire:click="order('resultado')">
                                    Resultado
                                    <span class="">@sortIcon('resultado', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[8%]">
                                <div class="cursor-pointer" wire:click="order('estatus')">
                                    Estatus
                                    <span class="">@sortIcon('estatus', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[8%]">
                                <div class="cursor-pointer" wire:click="order('fecha_inicio_jornada')">
                                    Fecha Inicio Jornada
                                    <span class="">@sortIcon('fecha_inicio_jornada', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[8%]">
                                <div class="cursor-pointer" wire:click="order('fecha_fin_jornada')">
                                    Fecha Fin Jornada
                                    <span class="">@sortIcon('fecha_fin_jornada', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="text-centrado text-base">Acciones</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->partidos as $partido)
                            <tr>
                                <td class="text-centrado text-base">{{ $partido->jornada }}</td>
                                <td class="text-centrado text-base">{{ $partido->numero_partido }}</td>
                                <td class="text-centrado text-base">{{ $partido->equipo_local }}</td>
                                <td class="text-centrado text-base">{{ $partido->equipo_visitante }}</td>
                                <td class="text-centrado text-base">{{ $partido->fecha_partido }}</td>
                                <td class="text-centrado text-base">{{ $partido->resultado }}</td>
                                <td class="text-centrado text-base">{{ $partido->estatus }}</td>
                                <td class="text-centrado text-base">{{ $partido->fecha_inicio_jornada }}</td>
                                <td class="text-centrado text-base">{{ $partido->fecha_fin_jornada }}</td>
                                <td class="text-centrado text-base">
                                    <div class="flex gap-2 justify-center"> <x-action-button class="bg-sky-600 ml-3"
                                            data-tippy="Editar"
                                            wire:click="$dispatch('abrir-modal-registrar-partido', { idPartido: {{ $partido->id_partido }} })">
                                            <i class="fa-solid fa-pen-to-square"></i> </x-action-button>
                                        <x-action-button class="bg-red-600 ml-3" data-tippy="Eliminar"
                                            wire:click="$dispatch('abrir-modal-eliminar-partido', { idPartido: {{ $partido->id_partido }} })">
                                            <i class="fa-solid fa-trash"></i> </x-action-button> </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($this->partidos->count() >= 20)
                @if ($this->partidos->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif
                {{ $this->partidos->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            @endif
        @else
            <div class="alerta lg:w-[900px]">{{ $mensajeFiltrado }}</div>
        @endif

    </div>
    <livewire:partidos.registrar-partidos-component />
    <livewire:partidos.eliminar-partidos-component />
</div>
