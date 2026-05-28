<div>
    <div class="mx-auto md:min-h-[500px] sm:px-6 lg:px-8">
        <h1>
            {{ __('Partidos 72') }}
        </h1>
        
        <div class="flex justify-end items-center mt-5 mb-2">
            <x-action-button
                class="bg-emerald-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                wire:click="$dispatch('abrir-modal-registrar-partido72', { idPartido72: null })">
                <i class="fa-solid fa-plus"></i>
                <span>Agregar Partido</span>
            </x-action-button>
        </div>

        @if (count($this->partidos) > 0)
            {{ $this->partidos->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="w-[10%]">
                                <div class="cursor-pointer" wire:click="order('numero_partido')">
                                    No.
                                    <span class="">@sortIcon('numero_partido', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[30%]">
                                <div class="cursor-pointer" wire:click="order('equipo_local')">
                                    Equipo Local
                                    <span class="">@sortIcon('equipo_local', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[30%]">
                                <div class="cursor-pointer" wire:click="order('equipo_visitante')">
                                    Equipo Visitante
                                    <span class="">@sortIcon('equipo_visitante', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[10%]">
                                <div class="cursor-pointer" wire:click="order('resultado')">
                                    Resultado
                                    <span class="">@sortIcon('resultado', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="text-centrado text-base w-[20%]">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->partidos as $partido)
                            <tr>
                                <td class="text-centrado text-base">{{ $partido->numero_partido }}</td>
                                <td class="text-centrado text-base">{{ $partido->equipo_local }}</td>
                                <td class="text-centrado text-base">{{ $partido->equipo_visitante }}</td>
                                <td class="text-centrado text-base">
                                    @if($partido->resultado)
                                        @if($partido->resultado === 'L')
                                            <span class="text-blue-600 font-bold">Local</span>
                                        @elseif($partido->resultado === 'V')
                                            <span class="text-green-600 font-bold">Visitante</span>
                                        @else
                                            <span class="text-gray-600 font-bold">Empate</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">Sin resultado</span>
                                    @endif
                                </td>
                                <td class="text-centrado text-base">
                                    <div class="flex gap-2 justify-center">
                                        <x-action-button class="bg-sky-600" data-tippy="Editar"
                                            wire:click="$dispatch('abrir-modal-registrar-partido72', { idPartido72: {{ $partido->id_partido_72 }} })">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </x-action-button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($this->partidos->total() >= 5)
                <x-paginacion-cantidad-mostrar />
            @endif
            {{ $this->partidos->onEachSide(1)->links(data: ['scrollTo' => false]) }}
        @else
            <div class="alerta lg:w-[900px]">{{ $mensajeFiltrado }}</div>
        @endif
    </div>

    <livewire:partidos72.registrar-partidos72-component />
</div>
