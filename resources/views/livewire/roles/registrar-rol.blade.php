<div>
    <x-dialog-modal wire:model="modalAbierto">

        <x-slot name="title">
            {{ $esEdicion ? 'Actualizar rol' : 'Agregar nuevo rol' }}
        </x-slot>

        <x-slot name="content">
            <div class="relative mb-2 mt-4 z-999">
                <div class="my-2">
                    <div class="leyenda mb-3">
                        Los campos marcados con asterisco rojo <span class="obligatorio">*</span> son obligatorios.
                    </div>
                    <form wire:submit.prevent="guardar">
                        <div class="mb-3 grid grid-cols-1 gap-2 w-10/12 mx-auto">
                            <div class="flex flex-col min-h-[80px]">
                                <x-input-label for="formRegistrarRol.nombre">Nombre <span class="obligatorio">*</span></x-input-label>
                                <x-text-input  wire:model.blur="formRegistrarRol.nombre" id="formRegistrarRol.nombre" maxlength="50"/>
                                @error('formRegistrarRol.nombre') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col">
                                <x-input-label for="formRegistrarRol.permisos">Permisos <span class="obligatorio">*</span></x-input-label>

                                @foreach ($this->permisos as $permiso)
                                    <div class="flex items-center mt-2">
                                        <input type="checkbox" wire:model.change="formRegistrarRol.permisos"
                                        checked="{{ in_array($permiso->id, $formRegistrarRol->permisos) }}"
                                        value="{{ $permiso->id }}" id="permission-{{ $permiso->id }}" class="form-checkbox h-5 w-5 text-cyan-600">
                                        <label for="permission-{{ $permiso->id }}" class="ml-2 text-gray-700">{{ Str::of($permiso->name)->replace('-', ' ')->ucfirst()  }}</label>
                                    </div>
                                @endforeach

                                @error('formRegistrarRol.permisos') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-primary-button type="button" class="mr-3" wire:click="guardar" target="guardar">
                {{$esEdicion ? 'Actualizar' : 'Guardar'}}
            </x-primary-button>
            <x-secondary-button type="button" wire:click="$toggle('modalAbierto')" wire:loading.attr="disabled">Cancelar</x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
