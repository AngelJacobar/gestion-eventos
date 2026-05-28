<div>
    @if($modalAbierto)
        <x-dialog-modal wire:model="modalAbierto">
        <x-slot name="title">
            Eliminar Quiniela
        </x-slot>
        <x-slot name="content">
                <p class="text-gray-700">
                    ¿Está seguro que desea eliminar la quiniela de <strong>{{ $nombreQuiniela }}</strong>?
                </p>
                <p class="text-sm text-red-600 mt-2">
                    Esta acción no se puede deshacer. Se eliminarán todos los pronósticos asociados a esta quiniela.
                </p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-danger-button wire:click="eliminar">
                    {{ __('Eliminar') }}
                </x-danger-button>
                <x-secondary-button wire:click="cancelar">
                    {{ __('Cancelar') }}
                </x-secondary-button>
            </div>
        </x-slot>
        </x-dialog-modal>
    @endif
</div>
