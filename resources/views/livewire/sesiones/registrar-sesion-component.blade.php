<x-dialog-modal wire:model="modalAbierto">

    <x-slot name="title">
        {{ $this->form->esEdicion ? 'Editar Sesión' : 'Nueva Sesión' }}
    </x-slot>

    <x-slot name="content">
        <div class="leyenda mb-4">
            Los campos con <span class="text-red-500">*</span> son obligatorios.

        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex flex-col">
                <x-input-label>
                    Evento <span class="text-red-500">*</span>
                </x-input-label>
                 <select wire:model='form.id_evento' wire:blur='liveValidation("form.id_evento")' class='border p-2'>
                    <option value="">Seleccione un Evento</option>
                    @foreach ($this->eventos as $evento)
                        <option value="{{ $evento->id_evento }}">{{ $evento->nombre }}</option>
                    @endforeach
                </select>

                @error('form.id_evento')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col">
                <x-input-label>
                    Nombre <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="text" wire:model='form.nombre' wire:blur='liveValidation("form.nombre")'
                    class="border p-2" />
                @error('form.nombre')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col">
                <x-input-label>
                    Nombre del ponente <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="text" wire:model='form.ponente' wire:blur='liveValidation("form.ponente")'
                    class="border p-2" />
                @error('form.ponente')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div class="flex flex-col">
                <x-input-label>
                    Fecha  de la sesión <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="date" wire:model='form.fecha'
                    wire:blur='liveValidation("form.fecha")' class="border p-2" />
                @error('form.fecha')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col">
                <x-input-label>
                    Hora en que inicia la sesión <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="time" wire:model='form.hora_inicio' wire:blur='liveValidation("form.hora_inicio")'
                    class="border p-2" />
                @error('form.hora_inicio')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col">
                <x-input-label>
                    Hora en que finaliza la sesión <span class="text-red-500">*</span>
                </x-input-label>
                <x-text-input type="time" wire:model='form.hora_fin' wire:blur='liveValidation("form.hora_fin")'
                    class="border p-2" />
                @error('form.hora_fin')
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
