<div>
    @if($modalAbierto)
        <x-dialog-modal wire:model="modalAbierto" maxWidth="6xl">
            <x-slot name="title">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-list-check text-blue-600"></i>
                    <div>
                        <div class="text-xl">Pronósticos de {{ $quiniela->nombre }}</div>
                        <div class="text-sm font-normal text-gray-600">
                            Puntaje: <span class="font-bold text-blue-600">{{ $quiniela->puntaje_total }}/72</span> • 
                            Teléfono: {{ $quiniela->telefono ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="content">
                <div class="max-h-[600px] overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($pronosticos as $pronostico)
                            <div class="border rounded-lg p-3 
                                {{ $pronostico['acierto'] === 'S' ? 'bg-green-50 border-green-300' : 
                                   ($pronostico['acierto'] === 'N' ? 'bg-red-50 border-red-300' : 'bg-gray-50 border-gray-300') }}">
                                
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-gray-700">Partido {{ $pronostico['numero_partido'] }}</span>
                                    
                                    @if($pronostico['acierto'] === 'S')
                                        <span class="text-green-600 text-sm font-semibold">✓ Acierto</span>
                                    @elseif($pronostico['acierto'] === 'N')
                                        <span class="text-red-600 text-sm font-semibold">✗ Fallo</span>
                                    @else
                                        <span class="text-gray-500 text-sm">Pendiente</span>
                                    @endif
                                </div>

                                <div class="text-sm text-gray-700 mb-2">
                                    <div class="font-semibold">{{ $pronostico['equipo_local'] }}</div>
                                    <div class="text-gray-500 text-xs">vs</div>
                                    <div class="font-semibold">{{ $pronostico['equipo_visitante'] }}</div>
                                </div>

                                <div class="flex items-center justify-between pt-2 border-t border-gray-300">
                                    <div class="text-sm">
                                        <span class="text-gray-600">Pronóstico:</span>
                                        <span class="font-bold ml-1 
                                            {{ $pronostico['pronostico'] === 'L' ? 'text-blue-600' : 
                                               ($pronostico['pronostico'] === 'V' ? 'text-red-600' : 'text-yellow-600') }}">
                                            {{ $pronostico['pronostico'] === 'L' ? 'Local' : 
                                               ($pronostico['pronostico'] === 'V' ? 'Visitante' : 'Empate') }}
                                        </span>
                                    </div>

                                    @if($pronostico['resultado'])
                                        <div class="text-sm">
                                            <span class="text-gray-600">Resultado:</span>
                                            <span class="font-bold ml-1 
                                                {{ $pronostico['resultado'] === 'L' ? 'text-blue-600' : 
                                                   ($pronostico['resultado'] === 'V' ? 'text-red-600' : 'text-yellow-600') }}">
                                                {{ $pronostico['resultado'] === 'L' ? 'L' : 
                                                   ($pronostico['resultado'] === 'V' ? 'V' : 'E') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 p-3 bg-blue-50 border-l-4 border-blue-500 rounded">
                    <div class="flex items-center gap-4 text-sm">
                        <div><span class="font-semibold">Total Aciertos:</span> 
                            <span class="text-green-600 font-bold">{{ collect($pronosticos)->where('acierto', 'S')->count() }}</span>
                        </div>
                        <div><span class="font-semibold">Total Fallos:</span> 
                            <span class="text-red-600 font-bold">{{ collect($pronosticos)->where('acierto', 'N')->count() }}</span>
                        </div>
                        <div><span class="font-semibold">Pendientes:</span> 
                            <span class="text-gray-600 font-bold">{{ collect($pronosticos)->whereNull('acierto')->count() }}</span>
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-secondary-button wire:click="cerrar">
                        Cerrar
                    </x-secondary-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>
