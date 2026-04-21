<x-dialog-modal wire:model="modalAbierto">

    <x-slot name="title">
        Confirmar eliminación        
    </x-slot>

    <x-slot name="content">
        ¿Está seguro de que desea eliminar esta asistencia al evento?
    </x-slot>
    
    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-primary-button type="button" wire:click="eliminar">
                Eliminar
            </x-primary-button>

            <x-secondary-button type="button" wire:click="cancelar">
                Cancelar
            </x-secondary-button>
        </div>
    </x-slot>

</x-dialog-modal>
