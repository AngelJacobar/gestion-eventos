<x-dialog-modal wire:model="modalAbierto">

    <x-slot name="title">
        {{ $this->form->esEdicion ? 'Editar Quiniela' : 'Nueva Quiniela' }}
    </x-slot>

    <x-slot name="content">
        <div class="leyenda mb-4">
            Los campos con <span class="text-red-500">*</span> son obligatorios.

        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="flex flex-col">
                <x-input-label>
                    Nombre <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="text" wire:model='form.nombre' wire:blur='liveValidation("form.nombre")' class="border p-2" />
                @error('form.nombre')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col">
                <x-input-label>
                   Telefono <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="text" wire:model='form.telefono' wire:blur='liveValidation("form.telefono")' class="border p-2" />
                @error('form.telefono')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            @foreach ($this->partidos as $partido)
                <div class="flex flex-col">
                    <x-input-label>
                        {{ $partido->equipo_local }} vs {{ $partido->equipo_visitante }} <span class="text-red-500">*</span>
                    </x-input-label>
                    <select wire:model='form.pronostico_{{ $partido->numero_partido }}' wire:blur='liveValidation("form.pronostico_{{ $partido->numero_partido }}")' class='border p-2'>
                        <option value="">Seleccione el pronostico</option>
                        <option value="L">{{ 'L'}}</option>
                        <option value="E">{{ 'E'}}</option>
                        <option value="V">{{ 'V'}}</option>
                    </select>
                    @error('form.pronostico_' . $partido->numero_partido)
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
            @endforeach
            


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