<div>
    <div class="mx-auto md:min-h-[500px] sm:px-6 lg:px-8">
        <h1>{{ __('Quinielas 72 Partidos') }}</h1>
        
        <div class="flex justify-between items-center mt-5 mb-2">
            <div class="flex gap-2">
                <x-action-button class="bg-emerald-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="$dispatch('abrir-modal-registrar-quiniela72', { idQuiniela72: null })">
                    <i class="fa-solid fa-plus"></i>
                    <span>Nueva Quiniela</span>
                </x-action-button>
                
                <x-action-button class="bg-blue-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="$dispatch('abrir-modal-calificar-quinielas72')">
                    <i class="fa-solid fa-calculator"></i>
                    <span>Calificar</span>
                </x-action-button>

                <x-action-button class="bg-red-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="exportarPDF">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>Exportar PDF</span>
                </x-action-button>

                <x-action-button class="bg-purple-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="exportarPDFConResultados">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>PDF con Resultados</span>
                </x-action-button>

                <x-action-button class="bg-orange-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="$dispatch('abrir-modal-importar-csv72')">
                    <i class="fa-solid fa-file-csv"></i>
                    <span>Importar CSV</span>
                </x-action-button>

                <x-action-button class="bg-gray-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="descargarPlantillaCSV">
                    <i class="fa-solid fa-download"></i>
                    <span>Plantilla CSV</span>
                </x-action-button>
            </div>

            @if($this->puntajeMaximo > 0)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                    <p class="font-bold">🏆 Puntaje Máximo: {{ $this->puntajeMaximo }}</p>
                    <p class="text-sm">Ganadores: {{ $this->quinielasGanadoras->count() }}</p>
                </div>
            @endif
        </div>

        @if (count($this->quinielas) > 0)
            {{ $this->quinielas->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="w-[5%]">#</th>
                            <th class="w-[20%]">
                                <div class="cursor-pointer" wire:click="order('nombre')">
                                    Nombre
                                    <span>@sortIcon('nombre', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[12%]">Teléfono</th>
                            <th class="w-[12%]">
                                <div class="cursor-pointer" wire:click="order('puntaje_total')">
                                    Puntaje
                                    <span>@sortIcon('puntaje_total', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[12%]">
                                <div class="cursor-pointer" wire:click="order('fecha_registro')">
                                    Fecha
                                    <span>@sortIcon('fecha_registro', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[10%]">Estatus</th>
                            <th class="w-[12%]">Pronósticos</th>
                            <th class="text-centrado text-base w-[10%]">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->quinielas as $index => $quiniela)
                            <tr class="{{ $quiniela->puntaje_total == $this->puntajeMaximo && $this->puntajeMaximo > 0 ? 'bg-yellow-50' : '' }}">
                                <td class="text-centrado text-base">
                                    {{ ($this->quinielas->currentPage() - 1) * $this->quinielas->perPage() + $index + 1 }}
                                    @if($quiniela->puntaje_total == $this->puntajeMaximo && $this->puntajeMaximo > 0)
                                        <span class="text-yellow-500">🏆</span>
                                    @endif
                                </td>
                                <td class="text-centrado text-base font-semibold">{{ $quiniela->nombre }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->telefono ?? 'N/A' }}</td>
                                <td class="text-centrado text-base">
                                    <span class="font-bold text-lg {{ $quiniela->puntaje_total >= 60 ? 'text-green-600' : ($quiniela->puntaje_total >= 40 ? 'text-blue-600' : 'text-gray-600') }}">
                                        {{ $quiniela->puntaje_total }} / 72
                                    </span>
                                </td>
                                <td class="text-centrado text-base">
                                    {{ \Carbon\Carbon::parse($quiniela->fecha_registro)->format('d/m/Y') }}
                                </td>
                                <td class="text-centrado text-base">
                                    @if($quiniela->estatus === 'S')
                                        <span class="text-green-600 font-semibold">Activa</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Inactiva</span>
                                    @endif
                                </td>
                                <td class="text-centrado text-base">
                                    <x-action-button class="bg-indigo-600" data-tippy="Ver Pronósticos"
                                        wire:click="$dispatch('abrir-modal-ver-pronosticos72', { idQuiniela72: {{ $quiniela->id_quiniela_72 }} })">
                                        <i class="fa-solid fa-eye"></i> Ver
                                    </x-action-button>
                                </td>
                                <td class="text-centrado text-base">
                                    <div class="flex gap-2 justify-center">
                                        <x-action-button class="bg-sky-600" data-tippy="Editar"
                                            wire:click="$dispatch('abrir-modal-registrar-quiniela72', { idQuiniela72: {{ $quiniela->id_quiniela_72 }} })">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </x-action-button>
                                        <x-action-button class="bg-red-600" data-tippy="Eliminar"
                                            wire:click="$dispatch('abrir-modal-eliminar-quiniela72', { idQuiniela72: {{ $quiniela->id_quiniela_72 }} })">
                                            <i class="fa-solid fa-trash"></i>
                                        </x-action-button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($this->quinielas->total() >= 5)
                <x-paginacion-cantidad-mostrar />
            @endif
            {{ $this->quinielas->onEachSide(1)->links(data: ['scrollTo' => false]) }}
        @else
            <div class="alerta lg:w-[900px]">No hay quinielas registradas</div>
        @endif
    </div>

    <livewire:quinielas72.registrar-quinielas72-component />
    <livewire:quinielas72.eliminar-quinielas72-component />
    <livewire:quinielas72.calificar-quinielas72-component />
    <livewire:quinielas72.ver-pronosticos-quinielas72-component />

    <!-- Modal para Importar CSV -->
    @if($mostrarModalImportar)
        <x-dialog-modal wire:model="mostrarModalImportar" maxWidth="lg">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-file-csv text-blue-600"></i>
                <span>Importar Quinielas desde CSV</span>
            </div>
        </x-slot>
        <x-slot name="content">
                <div class="space-y-4">
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4">
                        <p class="font-semibold mb-2">📄 Formato del CSV:</p>
                        <p class="text-sm mb-2">El archivo debe contener las siguientes columnas:</p>
                        <ul class="text-sm list-disc list-inside space-y-1">
                            <li><strong>Columna 1:</strong> Marca temporal (se ignora automáticamente)</li>
                            <li><strong>Columna 2:</strong> Nombre (obligatorio)</li>
                            <li><strong>Columna 3:</strong> Teléfono (opcional, 10 dígitos sin guiones)</li>
                            <li><strong>Columnas 4-75:</strong> 72 pronósticos con nombres de partidos como encabezados (Ej: "México vs Sudáfrica")</li>
                        </ul>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4">
                        <p class="font-semibold mb-2">⚠️ Importante:</p>
                        <ul class="text-sm list-disc list-inside space-y-1">
                            <li>El archivo debe estar en formato CSV</li>
                            <li>Cada fila representa una quiniela</li>
                            <li>La primera columna (Marca temporal) se ignora automáticamente</li>
                            <li>El teléfono debe contener exactamente 10 dígitos (Ej: 5512345678)</li>
                            <li>Los pronósticos deben ser: L (Local), V (Visitante) o E (Empate)</li>
                            <li>Se requieren exactamente 72 pronósticos por quiniela</li>
                            <li>Descarga la plantilla para ver los nombres de los partidos en cada columna</li>
                        </ul>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Seleccionar archivo CSV:
                        </label>
                        <input type="file" wire:model="archivoCSV" accept=".csv,.txt"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('archivoCSV') 
                            <span class="text-red-600 text-sm mt-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div wire:loading wire:target="archivoCSV" class="text-sm text-gray-600">
                        <i class="fa-solid fa-spinner fa-spin"></i> Cargando archivo...
                    </div>
                </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-primary-button wire:click="importarCSV" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="importarCSV">Importar</span>
                    <span wire:loading wire:target="importarCSV">
                        <i class="fa-solid fa-spinner fa-spin"></i> Importando...
                    </span>
                </x-primary-button>
                <x-secondary-button wire:click="$set('mostrarModalImportar', false)">
                    {{ __('Cancelar') }}
                </x-secondary-button>
            </div>
        </x-slot>
        </x-dialog-modal>
    @endif

    <!-- Reporte de Importación -->
    @if($mostrarReporte)
        <x-dialog-modal wire:model="mostrarReporte" maxWidth="lg">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-file-circle-check text-green-600"></i>
                <span>Reporte de Importación</span>
            </div>
        </x-slot>
        <x-slot name="content">
                <div class="space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $resultadoImportacion['registros_procesados'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Procesados</p>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $resultadoImportacion['registros_exitosos'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Exitosos</p>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold text-red-600">{{ $resultadoImportacion['registros_fallidos'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Fallidos</p>
                        </div>
                    </div>

                    @if(!empty($resultadoImportacion['errores']))
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 max-h-60 overflow-y-auto">
                            <p class="font-semibold text-red-800 mb-2">❌ Errores:</p>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach($resultadoImportacion['errores'] as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!empty($resultadoImportacion['detalles']))
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 max-h-60 overflow-y-auto">
                            <p class="font-semibold text-green-800 mb-2">✅ Registros Exitosos:</p>
                            <ul class="text-sm text-green-700 space-y-1">
                                @foreach($resultadoImportacion['detalles'] as $detalle)
                                    <li>{{ $detalle }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-primary-button wire:click="cerrarReporte">
                    {{ __('Cerrar') }}
                </x-primary-button>
            </div>
        </x-slot>
        </x-dialog-modal>
    @endif
</div>
