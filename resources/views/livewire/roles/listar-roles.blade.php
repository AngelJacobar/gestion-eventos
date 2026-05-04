<div>
    <div class="mx-auto md:min-h-[500px] sm:px-6 lg:px-8">
        <h1>
            {{ __('Roles') }}
        </h1>
        <div class="mt-6">
            <div x-data="{ open: false }" >
                <x-primary-button @click="open = !open" class="">
                    Criterios de búsqueda
                </x-primary-button>

                <div x-show="open" x-collapse.duration.500ms x-cloak>
                    
                    <form wire:submit.prevent="filtrar()"  class="marco">
                        <fieldset class="w-full grid grid-cols-12 gap-x-3">
                            <label class="col-span-12 sm:col-span-6 lg:col-span-4 lg:col-start-4 min-h-[80px] text-sm" for="buscarRol.nombre">
                                Nombre
                                <input type="text" id="buscarRol.nombre" class="w-full"
                                    maxlength="50" wire:model="buscarRol.nombre" placeholder="">
                                <div>
                                    @error('buscarRol.nombre')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </label>

                            <div class="col-span-12 sm:col-span-6 lg:col-span-4 min-h-[80px]">
                                {{-- Checkbox for each permission --}}
                                <p class="text-sm text-black ">Permisos</p>
                                @foreach ($this->permisos as $permiso)
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" wire:model="buscarRol.permisos"
                                        name="permisos"
                                        checked="{{ in_array($permiso->id, $buscarRol->permisos) }}"
                                        value="{{ $permiso->id }}" id="permission-{{ $permiso->id }}" class="form-checkbox h-5 w-5 text-cyan-600">
                                        <label for="permission-{{ $permiso->id }}" class="ml-2 text-gray-700">{{ Str::of($permiso->name)->replace('-', ' ')->ucfirst()  }}</label>
                                    </div>
                                @endforeach
                                @error('buscarRol.permisos')
                                    <span class="text-red-600 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                    
                        </fieldset>
                        <div class="my-5 w-full flex justify-center text-center">
                            <x-primary-button class="mr-4" type="submit" target="filtrar">
                                Filtrar
                            </x-primary-button>
                            <x-secondary-button type="button" wire:click="restablecer" target="restablecer">
                                Limpiar
                            </x-secondary-button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center content-center mt-5 mb-2">
            <div class="flex items-center text-sm">
                @if ($this->roles->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif
            </div>
            @can('registrar-rol')
                <x-action-button class="bg-emerald-600" wire:click="$dispatch('abrir-modal-asignar-permisos')" data-tippy="Agregar nuevo rol">
                    <i class="fa-solid fa-plus"></i>
                </x-action-button>
            @endcan
        </div>
        @if (count($this->roles) > 0)
            {{ $this->roles->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="w-[90%]">
                                <div class="cursor-pointer" wire:click="order('name')">
                                    Nombre
                                    <span class="">@sortIcon('name', $sort, $direction)</span>
                                </div>
                            </th>
                            @can('registrar-rol')
                            <th class="w-[10%]">Acciones </th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->roles as $rol)
                            <tr class="border">
                                <td>{{ $rol->name }}</td>

                                @can('registrar-rol')
                                    <td>
                                        <div class="flex flex-row justify-center items-center">
                                            <x-action-button class="bg-sky-600" data-tippy="Actualizar rol"
                                                wire:click="$dispatch('abrir-modal-asignar-permisos', { idRol: {{ $rol->id }} })"><i
                                                    class="fa-solid fa-pen-to-square"></i>
                                            </x-action-button>
                                        </div>
                                    </td>
                                    @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($this->roles->count() >= 20)
                @if ($this->roles->total() >= 5)
                    <x-paginacion-cantidad-mostrar />
                @endif
                {{ $this->roles->onEachSide(1)->links(data: ['scrollTo' => false]) }}
            @endif

            @can('registrar-rol')
            <div class="w-full flex flex-wrap justify-center items-center text-sm mt-5 text-gray-600">
                <span class="ico-table bg-emerald-600"> <i class="fa-solid fa-plus"></i></span>
                Agregar nuevo rol

                <span class="ico-table bg-sky-600 ml-3"> <i class="fa-solid fa-pen-to-square"></i></span>
                Actualizar rol
            </div>
            @endcan

        @else
            <div class="alerta lg:w-[900px]">{{ $mensajeFiltrado}}</div>
        @endif
    </div>
    @can('registrar-rol')
        <livewire:roles.registrar-rol-component />
    @endcan
</div>
