<div>
    <div class="mx-auto md:min-h-[500px] sm:px-6 lg:px-8">
        <h1>
            {{ __('Quinielas') }}
        </h1>
        
        

        <div class="flex justify-between items-center content-center mt-5 mb-2">
            
            <div class="flex justify-end items-center gap-2 mt-5 mb-2">
                <x-action-button
                    class="bg-yellow-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="abrirModalGanadoras">
                    <i class="fa-solid fa-trophy"></i>
                    <span>Ver Ganadoras</span>
                </x-action-button>
                
                <x-action-button
                    class="bg-red-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="exportarPDF">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>Exportar PDF</span>
                </x-action-button>
                
                <x-action-button
                    class="bg-green-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="exportarPDFConResultados">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>PDF con Resultados</span>
                </x-action-button>
                
                <x-action-button
                    class="bg-blue-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="$dispatch('abrir-modal-importar-csv')">
                    <i class="fa-solid fa-file-csv"></i>
                    <span>Importar CSV</span>
                </x-action-button>
                
                <x-action-button
                    class="bg-purple-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="$dispatch('abrir-modal-calificar-quinielas')">
                    <i class="fa-solid fa-calculator"></i>
                    <span>Calificar Quinielas</span>
                </x-action-button>
                
                <x-action-button
                    class="bg-emerald-600 flex items-center gap-2 w-auto px-4 text-base rounded-md"
                    wire:click="$dispatch('abrir-modal-registrar-quiniela', { idQuiniela: null })">
                    <i class="fa-solid fa-plus"></i>
                    <span>Agregar</span>
                </x-action-button>
            </div>
        </div>
        @if (count($this->quinielas) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="w-[5%]">
                                <div class="cursor-pointer" ">
                                    Quiniela
                                </div>
                            </th>
                            <th class="w-[12%]">
                                <div class="cursor-pointer" >
                                    Nombre
                                </div>
                            </th>
                            <th class="w-[12%]">
                                <div class="cursor-pointer" >
                                    Telefono
                                </div>
                            </th>
                           @foreach ($this->partidos as $partido)
                                <th class="w-[10%]">
                                    <div class="cursor-pointer">
                                        {{ $partido->equipo_local }} vs {{ $partido->equipo_visitante }}
                                    </div>
                                </th>
                           @endforeach
                            <th class="w-[10%]">Puntos</th>
                            <th class="w-[10%]">Acciones</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->quinielas as $quiniela)
                            <tr>
                                <td class="text-centrado text-base">{{ $quiniela->id_quiniela }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->nombre }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->telefono }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->pronostico_1 }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->pronostico_2 }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->pronostico_3 }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->pronostico_4 }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->pronostico_5 }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->pronostico_6 }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->pronostico_7 }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->pronostico_8 }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->pronostico_9 }}</td>
                                <td class="text-centrado text-base">{{ $quiniela->puntaje_total }}</td>

                                
                                <td class="text-centrado text-base">
                                    <div class="flex gap-2 justify-center"> <x-action-button class="bg-sky-600 ml-3"
                                            data-tippy="Editar"
                                            wire:click="$dispatch('abrir-modal-registrar-quiniela', { idQuiniela: {{ $quiniela->id_quiniela }} })">
                                            <i class="fa-solid fa-pen-to-square"></i> </x-action-button>
                                        <x-action-button class="bg-red-600 ml-3" data-tippy="Eliminar"
                                            wire:click="$dispatch('abrir-modal-eliminar-quiniela', { idQuiniela: {{ $quiniela->id_quiniela }} })">
                                            <i class="fa-solid fa-trash"></i> </x-action-button> </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        @else
            <div class="alerta lg:w-[900px]">{{ $mensajeFiltrado }}</div>
        @endif

    </div>
    
    <!-- Modal para Importar CSV -->
    <x-dialog-modal wire:model="mostrarModalImportar" maxWidth="2xl">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-file-csv text-blue-600"></i>
                <span>Importar Quinielas desde CSV</span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Formato del CSV:</strong> El archivo debe contener las siguientes columnas:
                            </p>
                            <ul class="list-disc list-inside text-sm text-blue-700 mt-2">
                                <li><strong>Marca temporal</strong> (opcional): Fecha de registro</li>
                                <li><strong>Nombre</strong> (obligatorio): Nombre del participante</li>
                                <li><strong>Telefono</strong> (opcional): Teléfono de contacto</li>
                                <li><strong>¿Cuántas quinielas registrarás hoy?</strong> (obligatorio): Cantidad de quinielas (1-10)</li>
                                <li><strong>Pronósticos</strong>: 9 columnas por cada quiniela (L, V, E)</li>
                            </ul>
                            <p class="text-sm text-blue-700 mt-2">
                                <strong>Valores de pronóstico:</strong>
                            </p>
                            <ul class="list-disc list-inside text-sm text-blue-700 ml-4">
                                <li><strong>L</strong> = Gana Local</li>
                                <li><strong>V</strong> = Gana Visitante</li>
                                <li><strong>E</strong> = Empate</li>
                            </ul>
                            <p class="text-sm text-blue-700 mt-2">
                                <i class="fa-solid fa-lightbulb"></i> <strong>Ejemplo:</strong> Si un usuario registra 3 quinielas, 
                                se crearán 3 registros con los nombres: "Juan - Q1", "Juan - Q2", "Juan - Q3"
                            </p>
                            <p class="text-sm text-blue-700 mt-2">
                                <i class="fa-solid fa-check-circle"></i> Compatible con exportaciones de Google Forms
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <x-input-label for="archivoCSV" value="Seleccionar archivo CSV" />
                    <input 
                        type="file" 
                        id="archivoCSV" 
                        wire:model="archivoCSV" 
                        accept=".csv,.txt"
                        class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                    >
                    @error('archivoCSV') 
                        <span class="text-red-600 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div wire:loading wire:target="archivoCSV" class="text-blue-600">
                    <i class="fa-solid fa-spinner fa-spin"></i> Cargando archivo...
                </div>

                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fa-solid fa-download"></i>
                    <a href="{{ asset('plantilla_quinielas.csv') }}" download class="text-blue-600 hover:underline">
                        Descargar plantilla de ejemplo
                    </a>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('mostrarModalImportar', false)">
                Cancelar
            </x-secondary-button>

            <x-action-button 
                wire:click="importarCSV" 
                wire:loading.attr="disabled"
                wire:target="importarCSV"
                class="ml-3 bg-blue-600">
                <span wire:loading.remove wire:target="importarCSV">
                    <i class="fa-solid fa-upload"></i> Importar
                </span>
                <span wire:loading wire:target="importarCSV">
                    <i class="fa-solid fa-spinner fa-spin"></i> Importando...
                </span>
            </x-action-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Modal para Reporte de Importación -->
    @if($mostrarReporte)
    <x-dialog-modal wire:model="mostrarReporte" maxWidth="2xl">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-chart-bar text-green-600"></i>
                <span>Reporte de Importación</span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <!-- Resumen -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Procesados</p>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ $resultadoImportacion['registros_procesados'] }}
                            </p>
                        </div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Exitosos</p>
                            <p class="text-2xl font-bold text-green-600">
                                {{ $resultadoImportacion['registros_exitosos'] }}
                            </p>
                        </div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Fallidos</p>
                            <p class="text-2xl font-bold text-red-600">
                                {{ $resultadoImportacion['registros_fallidos'] }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Errores -->
                @if(count($resultadoImportacion['errores']) > 0)
                <div class="mt-4">
                    <h4 class="font-semibold text-red-600 mb-2">
                        <i class="fa-solid fa-exclamation-triangle"></i> Errores:
                    </h4>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 max-h-60 overflow-y-auto">
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach($resultadoImportacion['errores'] as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Detalles de éxito -->
                @if(count($resultadoImportacion['detalles']) > 0)
                <div class="mt-4">
                    <h4 class="font-semibold text-green-600 mb-2">
                        <i class="fa-solid fa-check-circle"></i> Registros exitosos:
                    </h4>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 max-h-60 overflow-y-auto">
                        <ul class="list-disc list-inside text-sm text-green-700 space-y-1">
                            @foreach($resultadoImportacion['detalles'] as $detalle)
                                <li>{{ $detalle }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-action-button wire:click="cerrarReporte" class="bg-gray-600">
                <i class="fa-solid fa-times"></i> Cerrar
            </x-action-button>
        </x-slot>
    </x-dialog-modal>
    @endif
    
    <!-- Modal para Quinielas Ganadoras -->
    <x-dialog-modal wire:model="mostrarModalGanadoras" maxWidth="2xl">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-trophy text-yellow-600"></i>
                <span>Quinielas Ganadoras</span>
            </div>
        </x-slot>

        <x-slot name="content">
            @if($this->quinielasGanadoras->count() > 0)
                <div class="space-y-4">
                    <!-- Estadísticas -->
                    <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-2xl font-bold text-yellow-800">
                                    {{ $this->quinielasGanadoras->first()->puntaje_total }}
                                    <span class="text-base font-normal">puntos</span>
                                </p>
                                <p class="text-sm text-yellow-700">Puntaje máximo</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-yellow-800">
                                    {{ $this->quinielasGanadoras->count() }}
                                </p>
                                <p class="text-sm text-yellow-700">
                                    {{ $this->quinielasGanadoras->count() == 1 ? 'Ganadora' : 'Ganadoras' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de ganadoras -->
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-medal text-yellow-500"></i>
                            {{ $this->quinielasGanadoras->count() == 1 ? 'Quiniela Ganadora' : 'Quinielas Ganadoras' }}
                        </h4>
                        
                        <div class="space-y-3">
                            @foreach($this->quinielasGanadoras as $index => $quiniela)
                                <div class="bg-white border-2 border-yellow-300 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                                    {{ $index + 1 }}
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-lg">
                                                    {{ $quiniela->nombre }}
                                                </p>
                                                <p class="text-sm text-gray-600">
                                                    <i class="fa-solid fa-phone text-gray-400"></i>
                                                    {{ $quiniela->telefono }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="bg-yellow-100 px-4 py-2 rounded-full">
                                                <p class="text-2xl font-bold text-yellow-800">
                                                    {{ $quiniela->puntaje_total }}
                                                </p>
                                                <p class="text-xs text-yellow-700">puntos</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Pronósticos -->
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <p class="text-xs text-gray-500 mb-2">Pronósticos:</p>
                                        <div class="flex gap-2 flex-wrap">
                                            @for($i = 1; $i <= 9; $i++)
                                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded text-sm font-medium">
                                                    P{{ $i }}: {{ $quiniela->{"pronostico_{$i}"} }}
                                                </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Mensaje de felicitación -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4 mt-4">
                        <p class="text-center text-green-800 font-medium">
                            <i class="fa-solid fa-star text-yellow-500"></i>
                            ¡Felicidades {{ $this->quinielasGanadoras->count() == 1 ? 'al ganador' : 'a los ganadores' }}!
                            <i class="fa-solid fa-star text-yellow-500"></i>
                        </p>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fa-solid fa-trophy text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-600 text-lg font-medium">No hay quinielas ganadoras aún</p>
                    <p class="text-gray-500 text-sm mt-2">Las quinielas deben tener al menos 1 punto para aparecer como ganadoras.</p>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-action-button wire:click="cerrarModalGanadoras" class="bg-gray-600">
                <i class="fa-solid fa-times"></i> Cerrar
            </x-action-button>
        </x-slot>
    </x-dialog-modal>
    
    <livewire:quinielas.registrar-quinielas-component />
    <livewire:quinielas.eliminar-quinielas-component />
    <livewire:quinielas.calificar-quinielas-component />
</div>
