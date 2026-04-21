<?php

namespace App\Livewire\Vista;

use App\Livewire\Forms\Vista\BuscarEventosVistaForm;
use App\Traits\WithColumnFiltering;
use App\Traits\WithColumnSorting;
use App\Traits\WithTrimArreglosRecursivos;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;
use Modulos\GestionEventos\Vista\Actions\ListarEventosVistaAction;

class MostrarEventosComponent extends Component
{
    use Toastable;
    use WithPagination;
    use WithColumnSorting;
    use WithColumnFiltering;
    use WithTrimArreglosRecursivos;

    public BuscarEventosVistaForm $filtrosAplicados;

    public int $mes;
    public int $anio;

    public function mount(): void
    {
        $this->mes  = now()->month;
        $this->anio = now()->year;
        $this->actualizarFiltros();
    }

    private function actualizarFiltros()
    {
        // Creamos las fechas de inicio y fin del mes seleccionado
        //los argumentos que se le pasan a Carbon::create() son año, mes y día. En este caso, 
        //se establece el día como 1 para obtener el primer día del mes.
        //startOfMonth() ajusta la fecha al primer día del mes, y endOfMonth() ajusta la fecha al último día del mes.
        //toDateString() convierte la fecha a una cadena en formato 'Y-m-d', que es el formato comúnmente utilizado para almacenar fechas en bases de datos.
        $inicio = Carbon::create($this->anio, $this->mes, 1)->startOfMonth()->toDateString();
        $fin    = Carbon::create($this->anio, $this->mes, 1)->endOfMonth()->toDateString();

        $this->filtrosAplicados->fecha_inicio = $fin;
        $this->filtrosAplicados->fecha_fin    = $inicio;
    }

    #[Computed]
    public function calendario(): array
    {
        $primerDiaMes = Carbon::create($this->anio, $this->mes, 1);
        $inicioSemana = $primerDiaMes->dayOfWeek; // 0=Domingo, 1=Lunes, ..., 6=Sábado

        $calendario = [];
        $diaActual = $primerDiaMes->copy()->subDays($inicioSemana);

        for ($i = 0; $i < 42; $i++) {
            $eventosDelDia = $this->eventos->filter(function ($evento) use ($diaActual) {
                $inicio = Carbon::parse($evento->fecha_inicio)->startOfDay();
                $fin    = Carbon::parse($evento->fecha_fin)->startOfDay();
                return $diaActual->between($inicio, $fin);
            });

            $calendario[] = [
                'fecha' => $diaActual->copy(),
                'esDelMes' => $diaActual->month === $this->mes,
                'eventos' => $eventosDelDia,
            ];
            $diaActual->addDay();
        }

        return $calendario;
    }

    public function mesAnterior(): void
    {
        $fecha      = Carbon::create($this->anio, $this->mes)->subMonth();
        $this->mes  = $fecha->month;
        $this->anio = $fecha->year;
        $this->actualizarFiltros();
    }

    public function mesSiguiente(): void
    {
        $fecha      = Carbon::create($this->anio, $this->mes)->addMonth();
        $this->mes  = $fecha->month;
        $this->anio = $fecha->year;
        $this->actualizarFiltros();
    }

    public function render()
    {
        return view('livewire.vista.mostrar-eventos-component');
    }

    #[Computed]
    public function eventos()
    {
        return ListarEventosVistaAction::execute($this->filtrosAplicados)
            ->with('sesiones')
            ->orderBy('fecha_inicio', 'asc')
            ->get();
    }
}
