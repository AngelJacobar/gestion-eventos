<div>
    @if($modalAbierto)
        <x-dialog-modal wire:model="modalAbierto" maxWidth="lg">
        <x-slot name="title">
            {{ $form->esEdicion ? 'Editar Partido' : 'Registrar Partido' }}
        </x-slot>
        <x-slot name="content">
                <form wire:submit.prevent="guardar">
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Número de Partido -->
                        <div>
                            <x-input-label for="numero_partido" :value="__('Número de Partido (1-72)')" />
                            <x-text-input id="numero_partido" name="numero_partido" type="number" min="1" max="72"
                                class="mt-1 block w-full" wire:model="form.numero_partido"
                                wire:blur="liveValidation('numero_partido')" />
                            <x-input-error :messages="$errors->get('form.numero_partido')" class="mt-2" />
                        </div>

                        <!-- Equipo Local -->
                        <div>
                            <x-input-label for="equipo_local" :value="__('Equipo Local')" />
                            <x-text-input id="equipo_local" name="equipo_local" type="text"
                                class="mt-1 block w-full" wire:model="form.equipo_local"
                                wire:blur="liveValidation('equipo_local')" />
                            <x-input-error :messages="$errors->get('form.equipo_local')" class="mt-2" />
                        </div>

                        <!-- Equipo Visitante -->
                        <div>
                            <x-input-label for="equipo_visitante" :value="__('Equipo Visitante')" />
                            <x-text-input id="equipo_visitante" name="equipo_visitante" type="text"
                                class="mt-1 block w-full" wire:model="form.equipo_visitante"
                                wire:blur="liveValidation('equipo_visitante')" />
                            <x-input-error :messages="$errors->get('form.equipo_visitante')" class="mt-2" />
                        </div>

                        <!-- Resultado (solo en edición) -->
                        @if($form->esEdicion)
                            <div>
                                <x-input-label for="resultado" :value="__('Resultado')" />
                                <select id="resultado" name="resultado"
                                    class="mt-1 block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm"
                                    wire:model="form.resultado" wire:blur="liveValidation('resultado')">
                                    <option value="">Seleccione resultado</option>
                                    <option value="L">Local (L)</option>
                                    <option value="V">Visitante (V)</option>
                                    <option value="E">Empate (E)</option>
                                </select>
                                <x-input-error :messages="$errors->get('form.resultado')" class="mt-2" />
                            </div>
                        @endif
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
