<x-dialog-modal wire:model="modalAbierto">

    <x-slot name="title">
        {{ $this->form->esEdicion ? 'Editar Asistencia al Evento' : 'Nueva Asistencia al Evento' }}
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
            @if (auth()->user()->hasRole('administrador') || auth()->user()->hasRole('Organizador'))
                <div class="flex flex-col">

                    <x-input-label>
                        Usuario <span class="text-red-500">*</span>
                    </x-input-label>
                    <select wire:model='form.id_usuario' wire:blur='liveValidation("form.id_usuario")'
                        class='border p-2'>
                        <option value="">Seleccione un Usuario</option>
                        @foreach ($this->usuarios as $usuario)
                            <option value="{{ $usuario->id_usuario }}">{{ $usuario->nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}</option>
                        @endforeach
                    </select>

                    @error('form.id_usuario')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

            @endif


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
