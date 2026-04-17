<x-dialog-modal wire:model="modalAbierto">

    <x-slot name="title">
        {{ $this->form->esEdicion ? 'Editar Evento' : 'Nuevo Evento' }}
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
                    Fecha de inicio del evento <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="date" wire:model='form.fecha_inicio' wire:blur='liveValidation("form.fecha_inicio")' class="border p-2" />
                @error('form.fecha_inicio')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    
                @enderror
            </div>

            <div class="flex flex-col">
                <x-input-label>
                    Fecha de fin del evento <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="date" wire:model='form.fecha_fin' wire:blur='liveValidation("form.fecha_fin")' class="border p-2" />
                @error('form.fecha_fin')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div class="flex flex-col">
                <x-input-label>
                  Lugar del evento <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="text" wire:model='form.lugar' wire:blur='liveValidation("form.lugar")' class="border p-2" />
                @error('form.lugar')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col">
                <x-input-label>
                   Capacidad <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="number" wire:model='form.capacidad' wire:blur='liveValidation("form.capacidad")' class="border p-2" />
                @error('form.capacidad')
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