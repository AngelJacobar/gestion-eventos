<div>
    <div class="mx-auto md:min-h-[500px] sm:px-6 lg:px-8">
        <h1>
            {{ __('Usuarios') }}
        </h1>
        <div class="mt-6">
            <div x-data="{ open: false }">
                <x-primary-button @click="open = !open" class="">
                    Criterios de búsqueda
                </x-primary-button>

                <div x-show="open" x-collapse.duration.500ms  x-cloak>
                    
                    <form wire:submit.prevent="filtrar()" class="marco">
                        <fieldset class="w-full grid grid-cols-12 gap-x-3">
                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm" for="buscarUsuario.nombre">
                                Nombre(s)
                                <input type="text" id="buscarUsuario.nombre" class="w-full" maxlength="50"
                                    wire:model="buscarUsuario.nombre" placeholder="">
                                <div>
                                    @error('buscarUsuario.nombre')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>
                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm" for="buscarUsuario.primer_apellido">
                                Primer apellido
                                <input type="text" id="buscarUsuario.primer_apellido" class="w-full" maxlength="50"
                                    wire:model.live="buscarUsuario.primer_apellido" placeholder="">
                                <div>
                                    @error('buscarUsuario.primer_apellido')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>

                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm" for="buscarUsuario.segundo_apellido">
                                Segundo apellido
                                <input type="text" id="buscarUsuario.segundo_apellido" class="w-full" maxlength="50"
                                    wire:model="buscarUsuario.segundo_apellido" placeholder="">
                                <div>
                                    @error('buscarUsuario.segundo_apellido')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>

                            </label>

                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm" for="buscarUsuario.email">
                                Correo electrónico
                                <input type="text" id="buscarUsuario.email" class="w-full"
                                    maxlength="150" wire:model="buscarUsuario.email" placeholder="">
                                <div>
                                    @error('buscarUsuario.email')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>

                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px] text-sm" for="buscarUsuario.rol">
                                Rol
                                <select id="buscarUsuario.rol" class="w-full" wire:model="buscarUsuario.rol">
                                    <option value="todos">Todos</option>
                                    <div>
                                        @foreach ($this->roles as $rol)
                                            <option value="{{ $rol->name }}">
                                                {{ ucfirst($rol->name) }}
                                            </option>
                                        @endforeach
                                    </div>
                                </select>
                                <div>
                                    @error('buscarUsuario.rol')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>
                        </fieldset>
                        <div class="my-5 w-full flex justify-center text-center">
                            <x-primary-button class="mr-4" type="submit">
                                <svg wire:loading.delay wire:loading.attr="disabled" wire:target="filtrar"
                                    class="animate-spin -ml-1 mr-2 h-3 w-3 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Filtrar
                            </x-primary-button>
                            <x-secondary-button type="button" wire:click="restablecer">
                                <svg wire:loading.delay wire:loading.attr="disabled" wire:target="restablecer"
                                    class="animate-spin -ml-1 mr-2 h-3 w-3 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Limpiar
                            </x-secondary-button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center content-center mt-5 mb-2">
            <div class="flex items-center text-sm">
                @if ($this->usuarios->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif
            </div>
            @can('registrar-usuario')
                <x-action-button class="bg-emerald-600" wire:click="$dispatch('abrir-modal-registrar-usuario')" data-tippy="Agregar nuevo usuario">
                    <i class="fa-solid fa-plus"></i>
                </x-action-button>
            @endcan
        </div>
        @if (count($this->usuarios) > 0)
            {{ $this->usuarios->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="w-[16%]">
                                <div class="cursor-pointer" wire:click="order('nombre')">
                                    Nombre(s)
                                    <span class="">@sortIcon('nombre', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[16%]">
                                <div class="cursor-pointer" wire:click="order('primer_apellido')">
                                    Primer apellido
                                    <span class="">@sortIcon('primer_apellido', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[16%]">
                                <div class="cursor-pointer" wire:click="order('segundo_apellido')">
                                    Segundo apellido
                                    <span class="">@sortIcon('segundo_apellido', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[17%]">
                                <div class="cursor-pointer" wire:click="order('email')">
                                    Correo electrónico
                                    <span class="">@sortIcon('email', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[15%]">
                                <div class="cursor-pointer" wire:click="order('rol')">
                                    Rol
                                    <span class="">@sortIcon('rol', $sort, $direction)</span>
                                </div>
                            </th>
                            <th class="w-[15%]">
                                <div class="cursor-pointer" wire:click="order('activo')">
                                    Estado
                                    <span class="">@sortIcon('activo', $sort, $direction)</span>
                                </div>
                            </th>
                            @canany(['registrar-usuario', 'cambiar-estatus-usuario'])
                            <th class="w-[5%]">Acciones </th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->usuarios as $usuario)
                            <tr class="border">
                                <td>{{ $usuario->nombre }}</td>
                                <td>{{ $usuario->primer_apellido }}</td>
                                <td>{{ $usuario->segundo_apellido }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td class="text-center">
                                    <span class="bg-sky-100 text-sky-900 rounded-sm text-xs p-1 px-2 h-6">
                                        {{ ucfirst($usuario->rol ?? '') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if ($usuario->activo == \App\Enums\EstatusEnum::Activo)
                                        <span class="bg-green-100 text-green-900 rounded-sm text-xs p-1 px-2 h-6">
                                            {{ $usuario->activo->etiqueta() }}
                                        </span>
                                    @elseif ($usuario->activo == \App\Enums\EstatusEnum::Inactivo)
                                        <span class="bg-orange-100 text-orange-900 rounded-sm text-xs p-1 px-2 h-6">
                                            {{ $usuario->activo->etiqueta() }}
                                        </span>
                                    @endif

                                </td>
                                @canany(['registrar-usuario', 'cambiar-estatus-usuario'])
                                <td class="p-1">
                                    <div class="flex flex-row justify-center items-center">
                                        @can('registrar-usuario')
                                        <x-action-button class="bg-sky-600" title="Actualizar usuario"  data-tippy="Actualizar usuario"
                                            wire:click="$dispatch('abrir-modal-registrar-usuario', { idUsuario: {{ $usuario->id_usuario }} })">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </x-action-button>
                                        @endcan
                                        @can('cambiar-estatus-usuario')
                                        <div class="inline-flex items-center h-6">
                                            <span
                                                class="relative inline-flex items-center ml-1 cursor-pointer" data-tippy="Cambiar estatus"
                                                wire:click="$dispatch('abrir-modal-cambiar-estatus-usuario', { usuario: {{ $usuario->id_usuario }} })">
                                                <x-toggle :activo="$usuario->activo == \App\Enums\EstatusEnum::Activo ? true : false"/>
                                            </span>
                                        </div>
                                        @endcan
                                    </div>
                                </td>
                                @endcanany
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($this->usuarios->count() >= 20)
                @if ($this->usuarios->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif
                {{ $this->usuarios->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            @endif

            @canany(['registrar-usuario', 'cambiar-estatus-usuario'])
            <div class="w-full flex flex-wrap justify-center items-center text-sm mt-5 text-gray-600">
                @can('registrar-usuario')

                <span class="ico-table bg-emerald-600 ">
                    <i class="fa-solid fa-plus"></i>
                </span>
                Agregar nuevo usuario

                <span class="ico-table bg-sky-600 ml-3">
                    <i class="fa-solid fa-pen-to-square"></i>
                </span>
                Actualizar usuario

                @endcan

                @can('cambiar-estatus-usuario')
                <label for="" class="relative inline-flex items-center mx-3">
                    <x-toggle :activo="true" />
                    <span class="ml-1">Activo</span>
                </label>
                <label for="" class="relative inline-flex items-center mr-3">
                    <x-toggle :activo="false" />
                    <span class="ml-1">Inactivo</span>
                </label>
                @endcan
            </div>
            @endcanany
        @else
            <div class="alerta lg:w-[900px]">{{ $mensajeFiltrado }}</div>
        @endif

    </div>
    @can('registrar-usuario')
    <livewire:usuarios.registrar-usuario-component />
    @endcan
    @can('cambiar-estatus-usuario')
    <livewire:usuarios.cambiar-estatus-usuario-component />
    @endcan
</div>
