<x-dialog-modal wire:model="modalAbierto">

    <x-slot name="title">
        {{ $this->form->esEdicion ? 'Editar Partido' : 'Nuevo Partido' }}
    </x-slot>

    <x-slot name="content">
        <div class="leyenda mb-4">
            Los campos con <span class="text-red-500">*</span> son obligatorios.

        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="flex flex-col">
                <x-input-label>
                    Jornada <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="text" wire:model='form.jornada' wire:blur='liveValidation("form.jornada")' class="border p-2" />
                @error('form.jornada')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col">
                <x-input-label>
                    Numero de partido <span class="text-red-500">*</span>
                </x-input-label>
                <select wire:model='form.numero_partido' wire:blur='liveValidation("form.numero_partido")' class='border p-2'>
                    <option value="">Seleccione el numero de partido</option>
                    @for ($i = 1; $i <= 9; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                @error('form.numero_partido')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

           <div class="flex flex-col">
                <x-input-label>
                    Equipo Local <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="text" wire:model='form.equipo_local' wire:blur='liveValidation("form.equipo_local")' class="border p-2" />
                @error('form.equipo_local')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col">
                <x-input-label>
                    Equipo Visitante <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="text" wire:model='form.equipo_visitante' wire:blur='liveValidation("form.equipo_visitante")' class="border p-2" />
                @error('form.equipo_visitante')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col">
                <x-input-label>
                    Fecha del partido <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="date" wire:model='form.fecha_partido' wire:blur='liveValidation("form.fecha_partido")' class="border p-2" />
                @error('form.fecha_partido')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            @if($this->form->esEdicion)
            <div class="flex flex-col">
                <x-input-label>
                    Resultado
                </x-input-label>
                <select wire:model='form.resultado' wire:blur='liveValidation("form.resultado")' class='border p-2'>
                    <option value="">Sin resultado</option>
                    <option value="L">L - Ganó Local</option>
                    <option value="V">V - Ganó Visitante</option>
                    <option value="E">E - Empate</option>
                </select>
                @error('form.resultado')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            @endif

            <div class="flex flex-col">
                <x-input-label>
                   Fecha Inicio de Jornada <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="date" wire:model='form.fecha_inicio_jornada' wire:blur='liveValidation("form.fecha_inicio_jornada")' class="border p-2" />
                @error('form.fecha_inicio_jornada')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col">
                <x-input-label>
                    Fecha Fin de Jornada <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="date" wire:model='form.fecha_fin_jornada' wire:blur='liveValidation("form.fecha_fin_jornada")' class="border p-2" />
                @error('form.fecha_fin_jornada')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            


        </div>

    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-primary-button type="button" wire:click="guardar">
                Guardar
            </x-primary-button>

            <x-secondary-button type="button" wire:click="cancelar">
                Cancelar
            </x-secondary-button>
        </div>
    </x-slot>

</x-dialog-modal>