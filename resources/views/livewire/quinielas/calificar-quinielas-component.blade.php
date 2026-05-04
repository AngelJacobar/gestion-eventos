<x-dialog-modal wire:model="modalAbierto">

    <x-slot name="title">
        Confirmar calificación        
    </x-slot>

    <x-slot name="content">
        <div class="mb-4">
            <p class="text-base">¿Está seguro de que desea calificar todas las quinielas?</p>
            <p class="text-sm text-gray-600 mt-2">
                Esta acción recalculará el puntaje de todas las quinielas activas basándose en los resultados de los partidos.
            </p>
        </div>
    </x-slot>
    
    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-primary-button type="button" wire:click="calificar">
                Calificar
            </x-primary-button>

            <x-secondary-button type="button" wire:click="cancelar">
                Cancelar
            </x-secondary-button>
        </div>
    </x-slot>

</x-dialog-modal>
