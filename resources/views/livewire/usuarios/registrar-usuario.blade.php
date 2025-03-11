<div>
    <x-dialog-modal  wire:model="modalAbierto">

        <x-slot name="title">
            {{ $esEdicion ? 'Actualizar usuario' : 'Agregar nuevo usuario' }}
        </x-slot>

        <x-slot name="content">
            <div class="relative mb-2 mt-4 z-999">
                <div class="my-2">
                    <div class="leyenda mb-2">
                        Los campos marcados con asterisco rojo <span class="obligatorio">*</span> son obligatorios.
                    </div>
                    <form wire:submit.prevent="save" class="">
                        <div class="mb-3 grid grid-cols-1 gap-2 w-10/12 mx-auto">
                            <div class="flex flex-col">
                                <x-input-label for="formRegistrarUsuarioNombre">Nombre <span class="obligatorio">*</span></x-input-label>
                                <x-text-input  wire:model.blur="formRegistrarUsuario.nombre" id="formRegistrarUsuarioNombre" name="nombre" maxlength="50"/>
                                @error('formRegistrarUsuario.nombre') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col">
                                <x-input-label for="formRegistrarUsuarioPrimerApellido">Primer apellido <span class="obligatorio">*</span></x-input-label>
                                <x-text-input  wire:model.blur="formRegistrarUsuario.primer_apellido" id="formRegistrarUsuarioPrimerApellido" name="primer_apellido" maxlength="50"/>
                                @error('formRegistrarUsuario.primer_apellido') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col">
                                <x-input-label for="formRegistrarUsuarioSegundoApellido">Segundo apellido</x-input-label>
                                <x-text-input  wire:model.blur="formRegistrarUsuario.segundo_apellido" id="formRegistrarUsuarioSegundoApellido" name="segundo_apellido" maxlength="50"/>
                                @error('formRegistrarUsuario.segundo_apellido') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col">
                                <x-input-label for="formRegistrarUsuarioEmail">Correo electrónico <span class="obligatorio">*</span></x-input-label>
                                <x-text-input  wire:model.blur="formRegistrarUsuario.email" id="formRegistrarUsuarioEmail" name="email" maxlength="150"/>
                                @error('formRegistrarUsuario.email') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col">
                                <x-input-label for="formRegistrarUsuarioRol">Rol <span class="obligatorio">*</span></x-input-label>
                                <select name="rol" id="formRegistrarUsuarioRol"  wire:model.blur="formRegistrarUsuario.rol" value="{{ old('formRegistrarUsuario.rol') }}">
                                    <option value="">Seleccione un rol</option>
                                        @foreach ($this->roles as $rol)
                                            <option value="{{ $rol->name }}">
                                                {{ ucfirst($rol->name) }}
                                            </option>
                                        @endforeach
                                </select>
                                @error('formRegistrarUsuario.rol') <span class="error">{{ $message }}</span> @enderror
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
            <x-secondary-button type="button" class="" wire:click="$toggle('modalAbierto')" wire:loading.attr="disabled">Cancelar</x-secondary-button>
        </x-slot>

    </x-dialog-modal>
</div>
