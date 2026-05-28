<?php

namespace App\Livewire\Quinielas;

use App\Traits\WithColumnFiltering;
use App\Traits\WithColumnSorting;
use App\Traits\WithTrimArreglosRecursivos;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toastable;
use Modulos\Quinielas\Models\PartidosSemana;
use Modulos\Quinielas\Models\Quinielas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ListarQuinielasComponent extends Component
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

    // Propiedad para controlar el modal de ganadoras
    public $mostrarModalGanadoras = false;

    
    public function render()
    {
        return view('livewire.quinielas.listar-quinielas-component');
    }

     #[On('actualizar-lista-quinielas')]
    public function actualizar()
    {
        // Forzar la recarga de las propiedades computed
        unset($this->quinielas);
        unset($this->partidos);
        unset($this->puntajeMaximo);
        unset($this->quinielasGanadoras);
        
        // Forzar re-render del componente
        $this->dispatch('$refresh');
    }

    /**
     * Abrir el modal de importación CSV
     */
    #[On('abrir-modal-importar-csv')]
    public function abrirModalImportar()
    {
        $this->mostrarModalImportar = true;
        $this->reset(['archivoCSV', 'resultadoImportacion', 'mostrarReporte']);
    }

    /**
     * Importar quinielas desde un archivo CSV
     * Formato esperado del CSV:
     * Marca temporal,Nombre,Telefono,¿Cuántas quinielas registrarás hoy?,[9 pronósticos x cantidad de quinielas]
     * Nota: Este formato es compatible con exportaciones de Google Forms donde un usuario puede registrar múltiples quinielas
     */
    public function importarCSV()
    {
        // Validar que se haya cargado un archivo
        $this->validate([
            'archivoCSV' => 'required|file|mimes:csv,txt|max:10240', // Máximo 10MB
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
            
            // Detectar el encoding y convertir a UTF-8 si es necesario
            $encoding = mb_detect_encoding($contenido, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
            if ($encoding !== 'UTF-8') {
                $contenido = mb_convert_encoding($contenido, 'UTF-8', $encoding);
            }

            // Procesar el CSV
            $filas = array_map('str_getcsv', explode("\n", $contenido));
            
            // Validar que el archivo no esté vacío
            if (count($filas) < 2) {
                $this->error('El archivo CSV está vacío o solo contiene encabezados.');
                return;
            }

            // Obtener encabezados
            $encabezados = array_map('trim', $filas[0]);
            array_shift($filas); // Remover la fila de encabezados

            // Detectar el formato del CSV
            $indiceNombre = $this->buscarIndiceColumna($encabezados, ['Nombre', 'nombre']);
            $indiceTelefono = $this->buscarIndiceColumna($encabezados, ['Telefono', 'telefono', 'Teléfono', 'teléfono']);
            $indiceMarcaTemporal = $this->buscarIndiceColumna($encabezados, ['Marca temporal', 'marca temporal', 'fecha', 'Fecha']);
            $indiceCantidadQuinielas = $this->buscarIndiceColumna($encabezados, ['¿Cuántas quinielas registrarás hoy?', 'Cuantas quinielas', 'Cantidad']);

            if ($indiceNombre === false) {
                $this->error('No se encontró la columna "Nombre" en el CSV.');
                return;
            }

            if ($indiceCantidadQuinielas === false) {
                $this->error('No se encontró la columna "¿Cuántas quinielas registrarás hoy?" en el CSV.');
                return;
            }

            // Buscar el índice donde comienzan los pronósticos (después de la cantidad de quinielas)
            $indicePrimerPronostico = $indiceCantidadQuinielas + 1;

            DB::beginTransaction();

            // Procesar cada fila
            foreach ($filas as $numeroFila => $fila) {
                // Saltar filas vacías
                if (empty(array_filter($fila)) || count($fila) < 3) {
                    continue;
                }

                $numeroFilaReal = $numeroFila + 2; // +2 porque empezamos desde 0 y hay una fila de encabezado

                try {
                    // Extraer datos básicos
                    $nombre = isset($fila[$indiceNombre]) ? trim($fila[$indiceNombre]) : '';
                    $telefono = $indiceTelefono !== false && isset($fila[$indiceTelefono]) 
                        ? trim($fila[$indiceTelefono]) 
                        : null;

                    // Extraer cantidad de quinielas a registrar
                    $cantidadQuinielas = isset($fila[$indiceCantidadQuinielas]) 
                        ? (int)trim($fila[$indiceCantidadQuinielas]) 
                        : 1;

                    // Validar cantidad de quinielas
                    if ($cantidadQuinielas < 1 || $cantidadQuinielas > 10) {
                        throw new \Exception("La cantidad de quinielas debe estar entre 1 y 10. Valor recibido: {$cantidadQuinielas}");
                    }

                    // Extraer jornada de la marca temporal si existe
                    $jornada = 'Jornada 1'; // Valor por defecto
                    if ($indiceMarcaTemporal !== false && isset($fila[$indiceMarcaTemporal])) {
                        $marcaTemporal = $fila[$indiceMarcaTemporal];
                        // Intentar extraer la fecha para crear la jornada
                        if (preg_match('/(\d{1,2})\/(\d{1,2})\/(\d{4})/', $marcaTemporal, $matches)) {
                            $jornada = "Jornada {$matches[1]}/{$matches[2]}";
                        }
                    }

                    // Validar nombre obligatorio
                    if (empty($nombre)) {
                        $this->resultadoImportacion['registros_fallidos']++;
                        $this->resultadoImportacion['errores'][] = "Fila {$numeroFilaReal}: El nombre es obligatorio";
                        continue;
                    }

                    // Procesar cada quiniela
                    for ($quinielaNum = 0; $quinielaNum < $cantidadQuinielas; $quinielaNum++) {
                        $this->resultadoImportacion['registros_procesados']++;
                        
                        // Calcular el offset para esta quiniela (cada quiniela tiene 9 pronósticos)
                        $offsetQuiniela = $indicePrimerPronostico + ($quinielaNum * 9);

                        // Extraer los 9 pronósticos para esta quiniela
                        $pronosticos = [];
                        $quinielaTienePronosticos = false;
                        
                        for ($i = 0; $i < 9; $i++) {
                            $indicePronostico = $offsetQuiniela + $i;
                            $pronostico = isset($fila[$indicePronostico]) ? trim($fila[$indicePronostico]) : '';
                            
                            if (!empty($pronostico)) {
                                $quinielaTienePronosticos = true;
                                // Validar que sea L, V o E
                                $pronosticoUpper = strtoupper($pronostico);
                                if (!in_array($pronosticoUpper, ['L', 'V', 'E'])) {
                                    throw new \Exception("Quiniela " . ($quinielaNum + 1) . " - El pronóstico " . ($i + 1) . " debe ser L, V o E. Valor recibido: '{$pronostico}'");
                                }
                                $pronosticos[$i + 1] = $pronosticoUpper;
                            } else {
                                $pronosticos[$i + 1] = null;
                            }
                        }

                        // Si la quiniela no tiene ningún pronóstico, saltarla
                        if (!$quinielaTienePronosticos) {
                            $this->resultadoImportacion['registros_procesados']--;
                            continue;
                        }

                        // Preparar datos para inserción
                        $nombreConSufijo = $cantidadQuinielas > 1 
                            ? "{$nombre} - Q" . ($quinielaNum + 1)
                            : $nombre;

                        $datosQuiniela = [
                            'jornada' => $jornada,
                            'nombre' => $nombreConSufijo,
                            'telefono' => $telefono,
                            'puntaje_total' => 0,
                            'fecha_registro' => now(),
                        ];

                        // Agregar pronósticos
                        for ($i = 1; $i <= 9; $i++) {
                            $datosQuiniela["pronostico_{$i}"] = $pronosticos[$i];
                        }

                        // Crear la quiniela
                        Quinielas::create($datosQuiniela);

                        $this->resultadoImportacion['registros_exitosos']++;
                        $this->resultadoImportacion['detalles'][] = "Fila {$numeroFilaReal}: {$nombreConSufijo} - Registrado exitosamente";
                    }

                } catch (\Exception $e) {
                    $this->resultadoImportacion['registros_fallidos']++;
                    $mensajeError = "Fila {$numeroFilaReal}: Error - " . $e->getMessage();
                    $this->resultadoImportacion['errores'][] = $mensajeError;
                    
                    Log::error('Error al importar quiniela', [
                        'fila' => $numeroFilaReal,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            DB::commit();

            // Mostrar resultados
            $this->mostrarReporte = true;
            
            if ($this->resultadoImportacion['registros_exitosos'] > 0) {
                $this->success("Se importaron {$this->resultadoImportacion['registros_exitosos']} quinielas correctamente.");
            }
            
            if ($this->resultadoImportacion['registros_fallidos'] > 0) {
                $this->warning("No se pudieron importar {$this->resultadoImportacion['registros_fallidos']} registros. Revise el reporte de errores.");
            }

            // Actualizar la lista
            $this->dispatch('actualizar-lista-quinielas');
            
            // Cerrar el modal de importación
            $this->mostrarModalImportar = false;
            
            // Limpiar el archivo
            $this->reset('archivoCSV');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error al procesar el archivo CSV: ' . $e->getMessage());
            
            Log::error('Error general en importación de quinielas', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Buscar el índice de una columna por nombre (varios nombres posibles)
     */
    private function buscarIndiceColumna(array $encabezados, array $nombresColumna): int|false
    {
        foreach ($nombresColumna as $nombreColumna) {
            $indice = array_search($nombreColumna, $encabezados);
            if ($indice !== false) {
                return $indice;
            }
        }
        return false;
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
            // Obtener todas las quinielas activas
            $quinielas = Quinielas::orderBy('nombre', 'asc')
                ->get();

            // Verificar que haya quinielas para exportar
            if ($quinielas->isEmpty()) {
                $this->warning('No hay quinielas registradas para exportar.');
                return;
            }

            // Obtener partidos
            $partidos = PartidosSemana::orderBy('numero_partido', 'asc')
                ->get();

            // Obtener puntaje máximo para resaltar ganadoras
            $puntajeMaximo = $quinielas->max('puntaje_total');

            // Generar el PDF
            $pdf = Pdf::loadView('livewire.quinielas.quinielas-pdf', [
                'quinielas' => $quinielas,
                'partidos' => $partidos,
                'fechaExportacion' => now()->format('d/m/Y H:i:s'),
                'puntajeMaximo' => $puntajeMaximo
            ]);

            // Configurar orientación horizontal para mejor visualización
            $pdf->setPaper('A4', 'landscape');

            // Retornar el PDF para descarga
            $nombreArchivo = 'quinielas_' . now()->format('Y-m-d_His') . '.pdf';
            
            $this->success('PDF generado correctamente.');
            
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $nombreArchivo);

        } catch (\Exception $e) {
            $this->error('Error al generar el PDF: ' . $e->getMessage());
            
            Log::error('Error al exportar quinielas a PDF', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Exportar quinielas a PDF con resultados coloreados
     * Verde = Correcto, Rojo = Incorrecto, Amarillo = Pendiente
     */
    public function exportarPDFConResultados()
    {
        try {
            // Obtener todas las quinielas activas
            $quinielas = Quinielas::orderBy('nombre', 'asc')
                ->get();

            // Verificar que haya quinielas para exportar
            if ($quinielas->isEmpty()) {
                $this->warning('No hay quinielas registradas para exportar.');
                return;
            }

            // Obtener partidos
            $partidos = PartidosSemana::orderBy('numero_partido', 'asc')
                ->get();

            // Obtener puntaje máximo para resaltar ganadoras
            $puntajeMaximo = $quinielas->max('puntaje_total');

            // Generar el PDF con resultados
            $pdf = Pdf::loadView('livewire.quinielas.quinielas-resultados-pdf', [
                'quinielas' => $quinielas,
                'partidos' => $partidos,
                'fechaExportacion' => now()->format('d/m/Y H:i:s'),
                'puntajeMaximo' => $puntajeMaximo
            ]);

            // Configurar orientación horizontal para mejor visualización
            $pdf->setPaper('A4', 'landscape');

            // Retornar el PDF para descarga
            $nombreArchivo = 'quinielas_resultados_' . now()->format('Y-m-d_His') . '.pdf';
            
            $this->success('PDF con resultados generado correctamente.');
            
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $nombreArchivo);

        } catch (\Exception $e) {
            $this->error('Error al generar el PDF con resultados: ' . $e->getMessage());
            
            Log::error('Error al exportar quinielas con resultados a PDF', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }


   
    #[Computed]
     public function quinielas()
    {
        return Quinielas::orderBy('id_quiniela', 'asc')
            ->get();
    }

    #[Computed]
     public function partidos()
    {
        return PartidosSemana::orderBy('numero_partido', 'asc')
            ->get();
    }

    /**
     * Obtener el puntaje máximo de todas las quinielas activas
     */
    #[Computed]
    public function puntajeMaximo()
    {
        $puntaje = Quinielas::max('puntaje_total');
        return $puntaje ?? 0;
    }

    /**
     * Obtener las quinielas ganadoras (con el puntaje más alto)
     */
    #[Computed]
    public function quinielasGanadoras()
    {
        // Obtener el puntaje máximo
        $puntajeMaximo = Quinielas::max('puntaje_total');
        
        // Si no hay quinielas o todas tienen 0 puntos
        if ($puntajeMaximo === null || $puntajeMaximo === 0) {
            return collect([]);
        }
        
        // Obtener todas las quinielas con el puntaje máximo
        return Quinielas::where('puntaje_total', $puntajeMaximo)
            ->orderBy('nombre', 'asc')
            ->get();
    }

    /**
     * Abrir el modal de quinielas ganadoras
     */
    public function abrirModalGanadoras()
    {
        $this->mostrarModalGanadoras = true;
    }

    /**
     * Cerrar el modal de quinielas ganadoras
     */
    public function cerrarModalGanadoras()
    {
        $this->mostrarModalGanadoras = false;
    }




   
}
