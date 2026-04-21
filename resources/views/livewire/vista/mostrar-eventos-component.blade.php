<div>
    <section class="relative bg-stone-50">
        <div class="w-full py-24 relative z-10 backdrop-blur-3xl">
            <div class="w-full max-w-7xl mx-auto px-2 lg:px-8">
                <div class="grid grid-cols-12 gap-8 max-w-4xl mx-auto xl:max-w-full">
                    <div class="col-span-12 xl:col-span-5">
                        <h2 class="font-manrope text-3xl leading-tight text-gray-900 mb-1.5">Eventos del mes</h2>
                        <p class="text-lg font-normal text-gray-600 mb-8">
                            {{ ucfirst(\Carbon\Carbon::create($anio, $mes)->locale('es')->isoFormat('MMMM YYYY')) }}
                        </p>
                        @php
                            $paleta = [
                                [
                                    'list' => 'bg-purple-600',
                                    'bg' => 'bg-purple-50',
                                    'text' => 'text-purple-600',
                                    'dot' => 'bg-purple-600',
                                ],
                                [
                                    'list' => 'bg-sky-400',
                                    'bg' => 'bg-sky-50',
                                    'text' => 'text-sky-600',
                                    'dot' => 'bg-sky-600',
                                ],
                                [
                                    'list' => 'bg-rose-500',
                                    'bg' => 'bg-rose-50',
                                    'text' => 'text-rose-600',
                                    'dot' => 'bg-rose-600',
                                ],

                                [
                                    'list' => 'bg-emerald-600',
                                    'bg' => 'bg-emerald-50',
                                    'text' => 'text-emerald-600',
                                    'dot' => 'bg-emerald-600',
                                ],
                                [
                                    'list' => 'bg-amber-500',
                                    'bg' => 'bg-amber-50',
                                    'text' => 'text-amber-600',
                                    'dot' => 'bg-amber-600',
                                ],
                                [
                                    'list' => 'bg-violet-600',
                                    'bg' => 'bg-violet-50',
                                    'text' => 'text-violet-600',
                                    'dot' => 'bg-violet-600',
                                ],
                                [
                                    'list' => 'bg-teal-500',
                                    'bg' => 'bg-teal-50',
                                    'text' => 'text-teal-600',
                                    'dot' => 'bg-teal-600',
                                ],
                                [
                                    'list' => 'bg-orange-500',
                                    'bg' => 'bg-orange-50',
                                    'text' => 'text-orange-600',
                                    'dot' => 'bg-orange-600',
                                ],
                                [
                                    'list' => 'bg-pink-500',
                                    'bg' => 'bg-pink-50',
                                    'text' => 'text-pink-600',
                                    'dot' => 'bg-pink-600',
                                ],
                                [
                                    'list' => 'bg-lime-500',
                                    'bg' => 'bg-lime-50',
                                    'text' => 'text-lime-600',
                                    'dot' => 'bg-lime-600',
                                ],
                            ];
                            $colorPorEvento = [];
                            foreach ($this->eventos as $i => $ev) {
                                $colorPorEvento[$ev->id_evento] = $paleta[$i % count($paleta)];
                            }
                        @endphp
                        <div class="flex gap-5 flex-col">
                            @forelse($this->eventos as $evento)
                                @php $color = $colorPorEvento[$evento->id_evento]['list']; @endphp
                                <div class="p-6 rounded-xl bg-white">
                                    <div class="flex items-center gap-2.5 mb-3">
                                        <span class="w-2.5 h-2.5 rounded-full {{ $color }}"></span>
                                        <p class="text-base font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($evento->fecha_inicio)->locale('es')->isoFormat('D MMM YYYY') }}
                                            —
                                            {{ \Carbon\Carbon::parse($evento->fecha_fin)->locale('es')->isoFormat('D MMM YYYY') }}
                                        </p>
                                    </div>
                                    <h6 class="text-xl leading-8 font-semibold text-black mb-1">{{ $evento->nombre }}
                                    </h6>
                                    <p class="text-base font-normal text-gray-600">{{ $evento->lugar }}</p>
                                    <p class="text-sm text-gray-400 mt-1">Capacidad: {{ $evento->capacidad }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500">No hay eventos para este mes.</p>
                            @endforelse
                        </div>
                    </div>
                    <div
                        class="col-span-12 xl:col-span-7 px-2.5 py-5 sm:p-8 bg-gradient-to-b from-white/25 to-white xl:bg-white rounded-2xl max-xl:row-start-1">
                        <div class="flex flex-col md:flex-row gap-4 items-center justify-between mb-5">
                            <div class="flex items-center gap-4">
                                <h5 class="text-xl leading-8 font-semibold text-gray-900">
                                    {{ ucfirst(\Carbon\Carbon::create($anio, $mes)->locale('es')->isoFormat('MMMM YYYY')) }}
                                </h5>
                                <div class="flex items-center">
                                    <button wire:click="mesAnterior"
                                        class="text-indigo-600 p-1 rounded transition-all duration-300 hover:text-white hover:bg-indigo-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 16 16" fill="none">
                                            <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentcolor"
                                                stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="mesSiguiente"
                                        class="text-indigo-600 p-1 rounded transition-all duration-300 hover:text-white hover:bg-indigo-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 16 16" fill="none">
                                            <path d="M6.00236 3.99707L10.0025 7.99723L6 11.9998" stroke="currentcolor"
                                                stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="border border-indigo-200 rounded-xl">
                            <div class="grid grid-cols-7 rounded-t-3xl border-b border-indigo-200">
                                <div
                                    class="py-3.5 border-r rounded-tl-xl border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                    D</div>
                                <div
                                    class="py-3.5 border-r border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                    L</div>
                                <div
                                    class="py-3.5 border-r border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                    Ma</div>
                                <div
                                    class="py-3.5 border-r border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                    Mi</div>
                                <div
                                    class="py-3.5 border-r border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                    J</div>
                                <div
                                    class="py-3.5 border-r border-indigo-200 bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                    V</div>
                                <div
                                    class="py-3.5 rounded-tr-xl bg-indigo-50 flex items-center justify-center text-sm font-medium text-indigo-600">
                                    S</div>
                            </div>
                            <div class="grid grid-cols-7 rounded-b-xl">
                                @foreach ($this->calendario as $dia)
                                    @php
                                        $col = $loop->index % 7;
                                        $row = intdiv($loop->index, 7);
                                        $borderR = $col !== 6 ? 'border-r' : '';
                                        $borderB = $row !== 5 ? 'border-b' : '';
                                        $rounded =
                                            $loop->index === 35
                                                ? 'rounded-bl-xl'
                                                : ($loop->last
                                                    ? 'rounded-br-xl'
                                                    : '');
                                        $bgColor = $dia['esDelMes'] ? 'bg-white' : 'bg-gray-50';
                                        $textColor = $dia['esDelMes'] ? 'text-gray-900' : 'text-gray-400';
                                        $hasEvents = $dia['eventos']->isNotEmpty();
                                        $isToday = $dia['fecha']->isToday();
                                        $primerEvento = $hasEvents ? $dia['eventos']->first() : null;
                                        $colorEvento = $hasEvents
                                            ? $colorPorEvento[$primerEvento->id_evento] ?? $paleta[0]
                                            : null;
                                    @endphp
                                    <div
                                        class="flex xl:aspect-square max-xl:min-h-[60px] p-3.5 {{ $hasEvents ? 'relative' : '' }} {{ $bgColor }} {{ $borderR }} {{ $borderB }} border-indigo-200 {{ $rounded }} transition-all duration-300 hover:bg-indigo-50 cursor-pointer">
                                        @if ($isToday)
                                            <span
                                                class="text-xs font-semibold text-indigo-600 sm:text-white sm:w-6 sm:h-6 rounded-full sm:flex items-center justify-center sm:bg-indigo-600">
                                                {{ $dia['fecha']->day }}
                                            </span>
                                        @else
                                            <span class="text-xs font-semibold {{ $textColor }}">
                                                {{ $dia['fecha']->day }}
                                            </span>
                                        @endif
                                        @if ($hasEvents)
                                            <div
                                                class="absolute top-9 bottom-1 left-3.5 p-1.5 xl:px-2.5 h-max rounded {{ $colorEvento['bg'] }}">

                                                <p class="w-2 h-2 rounded-full {{ $colorEvento['dot'] }}"></p>
                                            </div>
                                            @if ($dia['eventos']->count() > 1)
                                                <span
                                                    class="absolute bottom-1 right-1 text-xs font-semibold text-indigo-500">
                                                    +{{ $dia['eventos']->count() - 1 }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @guest
        <legend class="text-sm text-gray-400 text-center">
            Para inscribirte a un evento, primero debes iniciar sesión y contar con un registro previo. Si aún no estás
            registrado, acércate a un organizador para que realice tu registro.
        </legend>
    @endguest
</div>
