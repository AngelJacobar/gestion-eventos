<div>
    <x-confirmation-modal wire:model.live="modalEstatusAbierto" :maxWidth="'2xl'">

        <x-slot name="title">
            Confirmar el cambio de estatus
        </x-slot>
        <x-slot name="content">
            <span @class([
                'text-red-600' => $desactivacionPropia,
            ])>
                {{ __($mensajeConfirmacion) }}
            </span>

        </x-slot>
        <x-slot name="footer">
            <x-primary-button wire:click="cambiarEstatusUsuario({{ $idUsuario ?? '' }})"
                wire:loading.attr="disabled">
                Confirmar
            </x-primary-button>

            <x-secondary-button wire:click="$toggle('modalEstatusAbierto')" wire:loading.attr="disabled" class="ml-3">
                Cancelar
            </x-secondary-button>
        </x-slot>

    </x-confirmation-modal>

    <script>
        window.addEventListener('logout-usuario', event => {
            setTimeout(function(){
                document.getElementById('logout-form').submit();
            }, 3000);
        });
    </script>

</div>
