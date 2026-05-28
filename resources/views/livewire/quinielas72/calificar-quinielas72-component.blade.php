<div>
    @if($modalAbierto)
        <x-dialog-modal wire:model="modalAbierto" maxWidth="2xl">
        <x-slot name="title">
            Calificar Quinielas de 72 Partidos
        </x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Partidos con resultado -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h3 class="font-semibold text-green-800 mb-2 text-sm">
                            <i class="fa-solid fa-check-circle"></i> Partidos con Resultado
                        </h3>
                        <p class="text-2xl font-bold text-green-600">{{ $this->partidosConResultado->count() }}</p>
                        <p class="text-xs text-gray-600">de 72 partidos totales</p>
                    </div>

                    <!-- Partidos sin resultado -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h3 class="font-semibold text-yellow-800 mb-2 text-sm">
                            <i class="fa-solid fa-exclamation-triangle"></i> Partidos Pendientes
                        </h3>
                        <p class="text-2xl font-bold text-yellow-600">{{ $this->partidosSinResultado->count() }}</p>
                        <p class="text-xs text-gray-600">sin resultado asignado</p>
                    </div>
                </div>

                @if($this->partidosSinResultado->count() > 0)
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 rounded">
                        <p class="font-bold text-sm">⚠️ Advertencia</p>
                        <p class="text-xs">Hay {{ $this->partidosSinResultado->count() }} partidos sin resultado. Solo se calificarán los partidos que tengan resultado asignado.</p>
                        <details class="mt-2">
                            <summary class="cursor-pointer text-xs font-semibold">Ver partidos pendientes</summary>
                            <ul class="mt-2 list-disc list-inside text-xs max-h-32 overflow-y-auto">
                                @foreach($this->partidosSinResultado->take(20) as $partido)
                                    <li>Partido #{{ $partido->numero_partido }}: {{ $partido->equipo_local }} vs {{ $partido->equipo_visitante }}</li>
                                @endforeach
                                @if($this->partidosSinResultado->count() > 20)
                                    <li class="text-gray-600">... y {{ $this->partidosSinResultado->count() - 20 }} más</li>
                                @endif
                            </ul>
                        </details>
                    </div>
                @endif

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-800 mb-2 text-sm">Proceso de Calificación</h3>
                    <p class="text-xs text-gray-700 mb-3">
                        Al calificar se compararán los pronósticos de cada quiniela con los resultados reales de los partidos. 
                        Se otorgará 1 punto por cada acierto.
                    </p>
                    <ul class="text-xs text-gray-600 list-disc list-inside space-y-1">
                        <li>Se reiniciarán todos los puntajes a 0</li>
                        <li>Se calificarán los {{ $this->partidosConResultado->count() }} partidos con resultado</li>
                        <li>Se actualizará el puntaje total de cada quiniela activa</li>
                    </ul>
                </div>

                <div class="bg-gray-100 border-l-4 border-gray-500 text-gray-700 p-3 rounded">
                    <p class="text-xs">¿Está seguro que desea calificar las quinielas? Se recalcularán todos los puntajes.</p>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-primary-button wire:click="calificar">
                    <i class="fa-solid fa-calculator"></i>
                    Iniciar Calificación
                </x-primary-button>
                <x-secondary-button wire:click="cancelar">
                    Cancelar
                </x-secondary-button>
            </div>
        </x-slot>
        </x-dialog-modal>
    @endif
</div>
