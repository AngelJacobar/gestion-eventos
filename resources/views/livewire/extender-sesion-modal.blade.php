<div>
    <div x-data="extendSessionModal" x-cloak>

        <div x-show="open" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Tu sesión está a punto de expirar
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                ¿Quieres continuar con tu sesión?
                            </p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <x-primary-button type="button" class="ms-4" @click="regenerateSesion">
                            Continuar
                        </x-primary-button>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-secondary-button type="submit" class="" @click="open = false">
                                {{ __('Log Out') }}
                            </x-secondary-button>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    {{-- Abrir modal para extender la sesion 3 minutos antes de que expire --}}
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('extendSessionModal', () => ({
            init() {
                setTimeout(() => {
                    this.open = true
                }, {{ (config('session.lifetime')  - 3) * 60 * 1000}})
            },
            open: false,
            regenerateSesion: function() {
                window.location.reload()
            },

        }))
    })
    </script>
@endpush
