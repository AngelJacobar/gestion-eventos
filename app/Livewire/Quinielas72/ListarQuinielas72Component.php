<?php

namespace App\Livewire\Quinielas72;

use App\Traits\WithColumnFiltering;
use App\Traits\WithColumnSorting;
use App\Traits\WithTrimArreglosRecursivos;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toastable;
use Modulos\Quinielas\Models\Quinielas72;
use Modulos\Quinielas\Models\Partidos72;
use Modulos\Quinielas\Models\QuinielasDetalle72;
use Modulos\Quinielas\Quinielas72\Actions\ListarQuinielas72Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ListarQuinielas72Component extends Component
{
    use Toastable;
    use WithPagination;
    use WithColumnSorting;
    use WithColumnFiltering;
    use WithTrimArreglosRecursivos;
    use WithFileUploads;

    // Propiedad para el archivo CSV
    public $archivoCSV;

    // Propiedades para el reporte de importación
    public $resultadoImportacion = [];
    public $mostrarReporte = false;
    
    // Propiedad para controlar el modal de importación
    public $mostrarModalImportar = false;

    protected $pageName = 'pagina';

    public function render()
    {
        return view('livewire.quinielas72.listar-quinielas72-component');
    }

    public function mount()
    {
        $this->restablecer();
    }

    #[On('actualizar-lista-quinielas72')]
    public function actualizar()
    {
        unset($this->quinielas);
        $this->dispatch('$refresh');
    }

    public function restablecer()
    {
        $this->sort = 'puntaje_total';
        $this->direction = 'desc';
        $this->cantidad = 20;
    }

    #[Computed]
    public function quinielas()
    {
        try {
            return ListarQuinielas72Action::execute()
                ->orderBy($this->sort, $this->direction)
                ->paginate(perPage: $this->cantidad, pageName: $this->pageName);
        } catch (\Exception $e) {
            $this->error('Error al obtener las quinielas');
            return collect();
        }
    }

    #[Computed]
    public function puntajeMaximo()
    {
        return Quinielas72::where('estatus', 'S')->max('puntaje_total') ?? 0;
    }

    #[Computed]
    public function quinielasGanadoras()
    {
        $puntajeMax = $this->puntajeMaximo;
        if ($puntajeMax === 0) {
            return collect();
        }
        return Quinielas72::where('estatus', 'S')
            ->where('puntaje_total', $puntajeMax)
            ->orderBy('fecha_registro', 'asc')
            ->get();
    }

    /**
     * Abrir el modal de importación CSV
     */
    #[On('abrir-modal-importar-csv72')]
    public function abrirModalImportar()
    {
        $this->mostrarModalImportar = true;
        $this->reset(['archivoCSV', 'resultadoImportacion', 'mostrarReporte']);
    }

    /**
     * Importar quinielas desde un archivo CSV
     * Formato esperado: nombre,telefono,id_partido_1,pronostico_1,id_partido_2,pronostico_2,...,id_partido_72,pronostico_72
     */
    public function importarCSV()
    {
        // Validar que se haya cargado un archivo
        $this->validate([
            'archivoCSV' => 'required|file|mimes:csv,txt|max:10240',
        ], [
            'archivoCSV.required' => 'Debe seleccionar un archivo CSV.',
            'archivoCSV.mimes' => 'El archivo debe ser de tipo CSV.',
            'archivoCSV.max' => 'El archivo no debe superar los 10MB.',
        ]);

        $this->resultadoImportacion = [
            'registros_procesados' => 0,
            'registros_exitosos' => 0,
            'registros_fallidos' => 0,
            'errores' => [],
            'detalles' => []
        ];

        try {
            // Leer el contenido del archivo
            $contenido = file_get_contents($this->archivoCSV->getRealPath());
            
            // Detectar encoding y convertir a UTF-8
            $encoding = mb_detect_encoding($contenido, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
            if ($encoding !== 'UTF-8') {
                $contenido = mb_convert_encoding($contenido, 'UTF-8', $encoding);
            }

            // Procesar CSV
            $filas = array_map('str_getcsv', explode("\n", $contenido));
            
            if (count($filas) < 2) {
                $this->error('El archivo CSV está vacío o solo contiene encabezados.');
                return;
            }

            // Obtener encabezados
            $encabezados = array_map('trim', $filas[0]);
            array_shift($filas);

            // Obtener todos los partidos disponibles
            $partidos = Partidos72::orderBy('numero_partido', 'asc')->get();
            
            if ($partidos->count() !== 72) {
                $this->error('Error: Debe haber exactamente 72 partidos registrados.');
                return;
            }

            DB::beginTransaction();

            foreach ($filas as $numeroFila => $fila) {
                if (empty(array_filter($fila)) || count($fila) < 4) {
                    continue;
                }

                $numeroFilaReal = $numeroFila + 2;
                $this->resultadoImportacion['registros_procesados']++;

                try {
                    // Extraer datos básicos (ignorando columna 0: Marca temporal)
                    $nombre = isset($fila[1]) ? trim($fila[1]) : '';
                    $telefono = isset($fila[2]) ? trim($fila[2]) : null;
                    
                    if (empty($nombre)) {
                        throw new \Exception("El nombre es obligatorio");
                    }

                    // Validar teléfono si está presente
                    if (!empty($telefono) && !preg_match('/^\d{10}$/', $telefono)) {
                        throw new \Exception("El teléfono debe contener exactamente 10 dígitos sin guiones");
                    }

                    // Crear la quiniela
                    $quiniela = Quinielas72::create([
                        'jornada' => 'Jornada ' . now()->format('Y-m-d'),
                        'nombre' => $nombre,
                        'telefono' => $telefono,
                        'puntaje_total' => 0,
                        'estatus' => 'S',
                        'fecha_registro' => now(),
                    ]);

                    // Procesar los 72 pronósticos (empiezan en columna 3)
                    $contadorPronosticos = 0;
                    for ($i = 0; $i < 72; $i++) {
                        $indicePronostico = 3 + $i; // Empieza en índice 3 (después de Marca temporal, Nombre, Teléfono)
                        $pronostico = isset($fila[$indicePronostico]) ? strtoupper(trim($fila[$indicePronostico])) : null;
                        
                        if ($pronostico && in_array($pronostico, ['L', 'V', 'E'])) {
                            QuinielasDetalle72::create([
                                'id_quiniela_72' => $quiniela->id_quiniela_72,
                                'id_partido_72' => $partidos[$i]->id_partido_72,
                                'pronostico' => $pronostico,
                                'acierto' => null,
                            ]);
                            $contadorPronosticos++;
                        }
                    }

                    if ($contadorPronosticos < 72) {
                        throw new \Exception("Se requieren 72 pronósticos. Solo se encontraron {$contadorPronosticos}");
                    }

                    $this->resultadoImportacion['registros_exitosos']++;
                    $this->resultadoImportacion['detalles'][] = "Fila {$numeroFilaReal}: {$nombre} - Registrado con {$contadorPronosticos} pronósticos";

                } catch (\Exception $e) {
                    $this->resultadoImportacion['registros_fallidos']++;
                    $this->resultadoImportacion['errores'][] = "Fila {$numeroFilaReal}: " . $e->getMessage();
                    
                    Log::error('Error al importar quiniela 72', [
                        'fila' => $numeroFilaReal,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            DB::commit();

            $this->mostrarReporte = true;
            
            if ($this->resultadoImportacion['registros_exitosos'] > 0) {
                $this->success("Se importaron {$this->resultadoImportacion['registros_exitosos']} quinielas correctamente.");
            }
            
            if ($this->resultadoImportacion['registros_fallidos'] > 0) {
                $this->warning("No se pudieron importar {$this->resultadoImportacion['registros_fallidos']} registros.");
            }

            $this->dispatch('actualizar-lista-quinielas72');
            $this->mostrarModalImportar = false;
            $this->reset('archivoCSV');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error al procesar el archivo CSV: ' . $e->getMessage());
            
            Log::error('Error general en importación de quinielas 72', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Cerrar el reporte de importación
     */
    public function cerrarReporte()
    {
        $this->mostrarReporte = false;
        $this->resultadoImportacion = [];
    }

    /**
     * Exportar quinielas a PDF
     */
    public function exportarPDF()
    {
        try {
            $quinielas = Quinielas72::where('estatus', 'S')
                ->with('detallesConPartidos')
                ->orderBy('nombre', 'asc')
                ->get();

            if ($quinielas->isEmpty()) {
                $this->warning('No hay quinielas registradas para exportar.');
                return;
            }

            $partidos = Partidos72::orderBy('numero_partido', 'asc')->get();
            $puntajeMaximo = $quinielas->max('puntaje_total');

            $pdf = Pdf::loadView('livewire.quinielas72.quinielas72-pdf', [
                'quinielas' => $quinielas,
                'partidos' => $partidos,
                'fechaExportacion' => now()->format('d/m/Y H:i:s'),
                'puntajeMaximo' => $puntajeMaximo
            ]);

            $pdf->setPaper('A3', 'landscape');

            $nombreArchivo = 'quinielas_72_' . now()->format('Y-m-d_His') . '.pdf';
            
            $this->success('PDF generado correctamente.');
            
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $nombreArchivo);

        } catch (\Exception $e) {
            $this->error('Error al generar el PDF: ' . $e->getMessage());
            
            Log::error('Error al exportar quinielas 72 a PDF', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Exportar quinielas a PDF con resultados coloreados
     */
    public function exportarPDFConResultados()
    {
        try {
            $quinielas = Quinielas72::where('estatus', 'S')
                ->with('detallesConPartidos')
                ->orderBy('puntaje_total', 'desc')
                ->orderBy('fecha_registro', 'asc')
                ->get();

            if ($quinielas->isEmpty()) {
                $this->warning('No hay quinielas registradas para exportar.');
                return;
            }

            $partidos = Partidos72::orderBy('numero_partido', 'asc')->get();
            $puntajeMaximo = $quinielas->max('puntaje_total');

            $pdf = Pdf::loadView('livewire.quinielas72.quinielas72-resultados-pdf', [
                'quinielas' => $quinielas,
                'partidos' => $partidos,
                'fechaExportacion' => now()->format('d/m/Y H:i:s'),
                'puntajeMaximo' => $puntajeMaximo
            ]);

            $pdf->setPaper('A3', 'landscape');

            $nombreArchivo = 'quinielas_72_resultados_' . now()->format('Y-m-d_His') . '.pdf';
            
            $this->success('PDF con resultados generado correctamente.');
            
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $nombreArchivo);

        } catch (\Exception $e) {
            $this->error('Error al generar el PDF: ' . $e->getMessage());
            
            Log::error('Error al exportar quinielas 72 con resultados a PDF', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Exportar plantilla CSV vacía
     */
    public function descargarPlantillaCSV()
    {
        try {
            $partidos = Partidos72::orderBy('numero_partido', 'asc')->get();
            
            $contenido = "Marca temporal,Nombre,Telefono";
            foreach ($partidos as $partido) {
                // Usar el nombre de los equipos en lugar de solo el número
                $nombrePartido = "{$partido->equipo_local} vs {$partido->equipo_visitante}";
                $contenido .= ",{$nombrePartido}";
            }
            $contenido .= "\n";
            
            // Agregar una fila de ejemplo
            $contenido .= date('d/m/Y H:i:s') . ",Juan Perez,5512345678";
            foreach ($partidos as $partido) {
                $contenido .= ",L";
            }
            $contenido .= "\n";

            $nombreArchivo = 'plantilla_quinielas_72.csv';
            
            return response()->streamDownload(function () use ($contenido) {
                echo "\xEF\xBB\xBF"; // UTF-8 BOM
                echo $contenido;
            }, $nombreArchivo, [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]);

        } catch (\Exception $e) {
            $this->error('Error al generar la plantilla: ' . $e->getMessage());
        }
    }
}
