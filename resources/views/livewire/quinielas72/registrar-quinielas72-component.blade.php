<div>
    @if($modalAbierto)
        <x-dialog-modal wire:model="modalAbierto" maxWidth="2xl">
        <x-slot name="title">
            {{ $form->esEdicion ? 'Editar Quiniela 72 Partidos' : 'Registrar Quiniela 72 Partidos' }}
        </x-slot>
        <x-slot name="content">
                <form wire:submit.prevent="guardar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Nombre -->
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre del Participante *')" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full"
                                wire:model="form.nombre" wire:blur="liveValidation('nombre')" />
                            <x-input-error :messages="$errors->get('form.nombre')" class="mt-2" />
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <x-input-label for="telefono" :value="__('Teléfono (10 dígitos)')" />
                            <x-text-input id="telefono" name="telefono" type="tel" 
                                class="mt-1 block w-full" placeholder="Ej: 5512345678"
                                maxlength="10" pattern="[0-9]{10}"
                                wire:model="form.telefono" wire:blur="liveValidation('telefono')" />
                            <x-input-error :messages="$errors->get('form.telefono')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Solo números, sin guiones ni espacios</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <h3 class="text-lg font-semibold mb-4">Pronósticos para los 72 Partidos</h3>
                        <p class="text-sm text-gray-600 mb-4">Selecciona el resultado para cada partido: L = Local, V = Visitante, E = Empate</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-[500px] overflow-y-auto p-2 bg-gray-50 rounded">
                            @foreach($this->partidos as $partido)
                                <div class="bg-white p-3 rounded shadow-sm">
                                    <div class="font-semibold text-sm mb-2">
                                        Partido #{{ $partido->numero_partido }}
                                    </div>
                                    <div class="text-xs text-gray-600 mb-2">
                                        <div>🏠 {{ $partido->equipo_local }}</div>
                                        <div>✈️ {{ $partido->equipo_visitante }}</div>
                                    </div>
                                    <div class="flex gap-2">
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="pronostico_{{ $partido->id_partido_72 }}"
                                                value="L"
                                                wire:model="form.pronosticos.{{ $partido->id_partido_72 }}"
                                                class="sr-only peer">
                                            <div class="w-full text-center py-1 px-2 rounded border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-100 peer-checked:text-blue-700 font-semibold text-sm">
                                                L
                                            </div>
                                        </label>
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="pronostico_{{ $partido->id_partido_72 }}"
                                                value="V"
                                                wire:model="form.pronosticos.{{ $partido->id_partido_72 }}"
                                                class="sr-only peer">
                                            <div class="w-full text-center py-1 px-2 rounded border-2 border-gray-300 peer-checked:border-green-500 peer-checked:bg-green-100 peer-checked:text-green-700 font-semibold text-sm">
                                                V
                                            </div>
                                        </label>
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="pronostico_{{ $partido->id_partido_72 }}"
                                                value="E"
                                                wire:model="form.pronosticos.{{ $partido->id_partido_72 }}"
                                                class="sr-only peer">
                                            <div class="w-full text-center py-1 px-2 rounded border-2 border-gray-300 peer-checked:border-gray-500 peer-checked:bg-gray-100 peer-checked:text-gray-700 font-semibold text-sm">
                                                E
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('form.pronosticos')" class="mt-2" />
                    </div>
                </form>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-primary-button wire:click="guardar">
                    {{ $form->esEdicion ? __('Actualizar') : __('Guardar') }}
                </x-primary-button>
                <x-secondary-button wire:click="cancelar">
                    {{ __('Cancelar') }}
                </x-secondary-button>
            </div>
        </x-slot>
        </x-dialog-modal>
    @endif
</div>
