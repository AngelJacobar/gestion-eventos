<x-dialog-modal wire:model="modalAbierto">

    <x-slot name="title">
        Generar Constancia
    </x-slot>

    <x-slot name="content">
        ¿Está seguro de que desea generar la constancia de este evento?
    </x-slot>
    
    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-primary-button type="button" wire:click="generarConstancia">
                Generar
            </x-primary-button>

            <x-secondary-button type="button" wire:click="cancelar">
                Cancelar
            </x-secondary-button>
        </div>
    </x-slot>

</x-dialog-modal>