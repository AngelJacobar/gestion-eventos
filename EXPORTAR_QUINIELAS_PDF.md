# 📄 Exportación de Quinielas a PDF

## 📋 Descripción

Funcionalidad para exportar todas las quinielas registradas a un documento PDF en formato horizontal (landscape) para mejor visualización.

---

## 🎯 Características

- ✅ **Exportación masiva**: Exporta todas las quinielas activas (estatus 'S')
- ✅ **Formato horizontal**: Documento en orientación landscape para mostrar todos los pronósticos
- ✅ **Diseño profesional**: Tabla con colores alternados, encabezados destacados y leyenda
- ✅ **Información completa**: 
  - ID de quiniela
  - Nombre del participante
  - Teléfono de contacto
  - 9 pronósticos (uno por partido)
  - Puntaje total
- ✅ **Estadísticas**: Total de quinielas y fecha de exportación
- ✅ **Colores por tipo de pronóstico**:
  - 🔵 **L** (Gana Local) - Azul
  - 🔴 **V** (Gana Visitante) - Rojo
  - ⚪ **E** (Empate) - Gris
- ✅ **Nombre de archivo con timestamp**: `quinielas_YYYY-MM-DD_HHMMSS.pdf`

---

## 🚀 Cómo Usar

### 1. **Acceder al Listado de Quinielas**
   - Navega a la sección de **Quinielas** en el sistema

### 2. **Exportar a PDF**
   - Haz clic en el botón **"Exportar PDF"** (botón rojo con ícono de PDF)
   - El sistema generará automáticamente el PDF

### 3. **Descargar el Archivo**
   - El navegador descargará el archivo PDF automáticamente
   - Nombre del archivo: `quinielas_2026-05-04_143025.pdf`

---

## 📊 Contenido del PDF

### Encabezado
```
🏆 Registro de Quinielas 🏆
Sistema de Gestión de Eventos
```

### Información General
- **Total de Quinielas**: Cantidad de registros exportados
- **Fecha de Exportación**: Fecha y hora en que se generó el PDF

### Tabla de Quinielas
| ID | Nombre | Teléfono | P1 | P2 | P3 | P4 | P5 | P6 | P7 | P8 | P9 | Puntos |
|----|--------|----------|----|----|----|----|----|----|----|----|----|----|
| 1  | Jacob - Q1 | 5624333938 | L | L | L | V | L | L | L | L | L | 0 |
| 2  | Jacob - Q2 | 5624333938 | E | V | L | V | L | V | L | V | L | 0 |

### Pie de Página
- **Leyenda**: L = Gana Local | V = Gana Visitante | E = Empate
- **Copyright**: © 2026 - Todos los derechos reservados

---

## 🛠️ Configuración

### Requisitos
- ✅ **DomPDF** instalado: `barryvdh/laravel-dompdf`
- ✅ Archivo de configuración publicado: `config/dompdf.php`

### Personalización

Si deseas modificar el diseño del PDF, edita el archivo:
```
resources/views/livewire/quinielas/quinielas-pdf.blade.php
```

**Opciones de personalización:**
- Colores de la tabla
- Tamaño de fuente
- Orientación del papel (portrait/landscape)
- Encabezados y pie de página
- Leyenda

---

## 🔧 Configuración de DomPDF

El archivo de configuración se encuentra en:
```
config/dompdf.php
```

**Parámetros importantes:**
```php
// Orientación del papel
'orientation' => 'landscape', // portrait o landscape

// Tamaño del papel
'paper_size' => 'A4', // A4, letter, legal, etc.

// Habilitar imágenes remotas
'enable_remote' => false,

// Habilitar CSS
'enable_css_float' => false,
```

---

## ⚠️ Validaciones

El sistema valida lo siguiente antes de generar el PDF:

1. **Quinielas existentes**: Debe haber al menos una quiniela registrada
   - Si no hay quinielas, muestra el mensaje: *"No hay quinielas registradas para exportar"*

2. **Estatus activo**: Solo exporta quinielas con `estatus = 'S'`

3. **Ordenamiento**: Las quinielas se ordenan alfabéticamente por nombre

---

## 📝 Ejemplo de Uso

```php
// En el componente Livewire
public function exportarPDF()
{
    // Obtener quinielas activas
    $quinielas = Quinielas::where('estatus', 'S')
        ->orderBy('nombre', 'asc')
        ->get();

    // Verificar que existan quinielas
    if ($quinielas->isEmpty()) {
        $this->warning('No hay quinielas registradas para exportar.');
        return;
    }

    // Obtener partidos
    $partidos = PartidosSemana::where('estatus', 'S')
        ->orderBy('numero_partido', 'asc')
        ->get();

    // Generar PDF
    $pdf = Pdf::loadView('livewire.quinielas.quinielas-pdf', [
        'quinielas' => $quinielas,
        'partidos' => $partidos,
        'fechaExportacion' => now()->format('d/m/Y H:i:s')
    ]);

    // Configurar orientación
    $pdf->setPaper('A4', 'landscape');

    // Descargar
    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->output();
    }, 'quinielas_' . now()->format('Y-m-d_His') . '.pdf');
}
```

---

## 🎨 Estilos del PDF

### Colores utilizados
- **Encabezado de tabla**: `#34495e` (Gris oscuro)
- **Filas alternas**: `#ecf0f1` (Gris claro)
- **Columna de puntaje**: `#f39c12` (Naranja)
- **Pronóstico Local (L)**: `#3498db` (Azul)
- **Pronóstico Visitante (V)**: `#e74c3c` (Rojo)
- **Pronóstico Empate (E)**: `#95a5a6` (Gris)

### Tamaños de fuente
- **Título principal**: 18px
- **Información general**: 10px
- **Contenido de tabla**: 8px
- **Encabezados de columnas**: 8px (negrita)
- **Pie de página**: 8px

---

## 🐛 Solución de Problemas

### Error: "No hay quinielas registradas para exportar"
**Causa**: No existen quinielas con estatus activo ('S')  
**Solución**: Registra quinielas o verifica que tengan el estatus correcto

### Error: "Class 'Barryvdh\DomPDF\Facade\Pdf' not found"
**Causa**: DomPDF no está instalado correctamente  
**Solución**: 
```bash
composer require barryvdh/laravel-dompdf
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

### El PDF no se descarga
**Causa**: Problema con el método de descarga  
**Solución**: Verifica que el método `exportarPDF()` retorne correctamente el `response()->streamDownload()`

### El diseño del PDF se ve mal
**Causa**: Estilos CSS no compatibles con DomPDF  
**Solución**: DomPDF tiene limitaciones con CSS3. Usa estilos básicos y tablas

---

## 📚 Recursos Adicionales

- **Documentación de DomPDF**: [https://github.com/barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)
- **CSS soportado por DomPDF**: [https://github.com/dompdf/dompdf/wiki/CSSCompatibility](https://github.com/dompdf/dompdf/wiki/CSSCompatibility)
- **Livewire Documentation**: [https://livewire.laravel.com/](https://livewire.laravel.com/)

---

## ✅ Checklist de Implementación

- [x] Instalar DomPDF (`composer require barryvdh/laravel-dompdf`)
- [x] Publicar configuración (`php artisan vendor:publish`)
- [x] Agregar método `exportarPDF()` en el componente Livewire
- [x] Crear vista `quinielas-pdf.blade.php`
- [x] Agregar botón "Exportar PDF" en la vista principal
- [x] Importar `Barryvdh\DomPDF\Facade\Pdf` en el componente
- [x] Configurar orientación landscape para mejor visualización
- [x] Agregar validaciones (quinielas vacías)
- [x] Agregar manejo de errores con logs
- [x] Probar con diferentes cantidades de quinielas

---

## 🎉 ¡Listo para usar!

La funcionalidad de exportación a PDF está completamente implementada y lista para usar. Solo haz clic en el botón **"Exportar PDF"** y disfruta de tus quinielas en formato profesional.
