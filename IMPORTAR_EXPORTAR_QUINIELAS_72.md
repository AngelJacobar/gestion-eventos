# Guía de Importación y Exportación - Quinielas 72 Partidos

## 📥 Importar Quinielas desde CSV

### Formato del Archivo CSV

El archivo CSV debe seguir este formato específico:

```csv
Nombre,Telefono,P1,P2,P3,P4,...,P72
Juan Perez,555-1234,L,V,E,L,...,V
Maria Garcia,555-5678,V,L,L,E,...,L
```

### Estructura de Columnas

| Columna | Descripción | Obligatorio | Ejemplo |
|---------|-------------|-------------|---------|
| 1 | Nombre del participante | **Sí** | Juan Perez |
| 2 | Teléfono de contacto | No | 555-1234 |
| 3-74 | 72 pronósticos (L/V/E) | **Sí** | L,V,E,L,V,... |

### Valores Permitidos para Pronósticos

- **L** = Gana el equipo Local
- **V** = Gana el equipo Visitante  
- **E** = Empate

**Nota:** Los valores son case-insensitive (se aceptan tanto mayúsculas como minúsculas).

### Pasos para Importar

1. **Preparar el archivo:**
   - Crear un archivo CSV con el formato especificado
   - Asegurarse de que cada fila tenga exactamente 74 columnas (nombre + teléfono + 72 pronósticos)
   - Guardar el archivo con codificación UTF-8

2. **Descargar plantilla:**
   - En la interfaz de Quinielas 72, click en botón "Plantilla CSV"
   - Se descargará un archivo con la estructura correcta y un ejemplo

3. **Importar:**
   - Click en botón "Importar CSV"
   - Seleccionar el archivo preparado
   - Click en "Importar"
   - Esperar a que se procese el archivo

4. **Revisar resultados:**
   - Se mostrará un reporte con:
     - Registros procesados
     - Registros exitosos
     - Registros fallidos
     - Detalle de errores (si los hay)

### Ejemplo de Archivo CSV Válido

```csv
Nombre,Telefono,P1,P2,P3,P4,P5,P6,P7,P8,P9,P10,P11,P12,P13,P14,P15,P16,P17,P18,P19,P20,P21,P22,P23,P24,P25,P26,P27,P28,P29,P30,P31,P32,P33,P34,P35,P36,P37,P38,P39,P40,P41,P42,P43,P44,P45,P46,P47,P48,P49,P50,P51,P52,P53,P54,P55,P56,P57,P58,P59,P60,P61,P62,P63,P64,P65,P66,P67,P68,P69,P70,P71,P72
Juan Perez,555-1234,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E
Maria Garcia,555-5678,V,L,L,E,V,L,E,V,L,L,E,V,L,E,V,L,L,E,V,L,E,V,L,L,E,V,L,E,V,L,L,E,V,L,E,V,L,L,E,V,L,E,V,L,L,E,V,L,E,V,L,L,E,V,L,E,V,L,L,E,V,L,E,V,L,L,E,V,L,E,V,L
Pedro Lopez,,E,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L
```

### Validaciones Aplicadas

El sistema valida:

- ✅ **Archivo:** Debe ser formato CSV (extensiones .csv o .txt)
- ✅ **Tamaño:** Máximo 10MB
- ✅ **Nombre:** Obligatorio, no puede estar vacío
- ✅ **Pronósticos:** Deben ser exactamente 72 valores L, V o E
- ✅ **Partidos:** Debe haber 72 partidos registrados en el sistema

### Manejo de Errores

Si una fila tiene errores:
- Se omite esa quiniela específica
- Se continúa procesando las demás
- Se registra el error en el reporte
- Se guarda un log en el sistema

Errores comunes:
- ❌ Nombre vacío
- ❌ Menos de 72 pronósticos
- ❌ Pronósticos con valores inválidos (diferentes de L, V, E)
- ❌ Formato de archivo incorrecto

---

## 📤 Exportar Quinielas a PDF

### Tipos de Exportación

#### 1. PDF Simple

**Botón:** "Exportar PDF"  
**Descripción:** Genera un PDF con todas las quinielas y sus pronósticos sin indicar resultados.

**Características:**
- Orientación horizontal (landscape)
- Tamaño A3 para mejor visualización de las 72 columnas
- Tabla con todos los pronósticos
- Puntaje total por quiniela
- Resalta quinielas ganadoras con color azul

**Uso recomendado:**
- Imprimir antes de que se jueguen los partidos
- Validar pronósticos registrados
- Auditoría de participación

#### 2. PDF con Resultados

**Botón:** "PDF con Resultados"  
**Descripción:** Genera un PDF con colores que indican aciertos y errores.

**Código de Colores:**
- 🟢 **Verde** = Pronóstico correcto (acierto)
- 🔴 **Rojo** = Pronóstico incorrecto (error)
- 🟡 **Amarillo** = Partido pendiente (sin resultado aún)
- ⚪ **Gris** = Sin pronóstico

**Características:**
- Muestra el estado de cada pronóstico
- Ordena por puntaje (mayor a menor)
- Resalta ganadores
- Incluye leyenda de colores

**Uso recomendado:**
- Después de calificar las quinielas
- Publicar resultados oficiales
- Identificar visualmente ganadores

### Información Incluida en PDFs

Ambos PDFs incluyen:
- **Header:** Título del reporte y fecha de exportación
- **Estadísticas:**
  - Total de quinielas registradas
  - Puntaje máximo alcanzado
  - Número de ganadores
- **Tabla de Quinielas:**
  - Nombre del participante
  - 72 pronósticos (uno por columna)
  - Puntaje total obtenido
- **Footer:**
  - Leyenda de símbolos
  - Copyright e información del sistema

### Formato Técnico

- **Tamaño de papel:** A3 (297 x 420 mm)
- **Orientación:** Horizontal (landscape)
- **Fuente:** Arial, tamaño variable según densidad de datos
- **Columnas:** 74 totales (nombre + 72 partidos + puntaje)
- **Optimización:** Texto vertical en headers para ahorrar espacio

### Consideraciones de Impresión

Para mejor calidad de impresión:
- Usar impresora de alta resolución (mínimo 600 DPI)
- Papel A3 para visualización óptima
- Si solo hay impresora A4, el PDF se ajustará pero será menos legible
- Considerar impresión a color para el PDF de resultados

---

## 🔄 Flujo Completo de Trabajo

### Escenario 1: Registro Manual + Exportación

1. Registrar quinielas manualmente desde la interfaz web
2. Exportar PDF simple para validación
3. Asignar resultados a los partidos
4. Calificar quinielas
5. Exportar PDF con resultados
6. Publicar y entregar premios

### Escenario 2: Importación Masiva + Exportación

1. Descargar plantilla CSV
2. Llenar plantilla con datos de participantes
3. Importar archivo CSV
4. Revisar reporte de importación
5. Exportar PDF simple para validación
6. Asignar resultados a partidos
7. Calificar quinielas
8. Exportar PDF con resultados

### Escenario 3: Registro Híbrido

1. Registrar algunas quinielas manualmente
2. Importar el resto desde CSV
3. Exportar PDF combinado
4. Continuar con calificación y resultados

---

## 🎯 Casos de Uso

### Caso 1: Evento Deportivo Grande (100+ participantes)

**Recomendación:** Usar importación CSV

**Pasos:**
1. Crear formulario Google Forms para recopilar pronósticos
2. Exportar respuestas a CSV
3. Adaptar formato al requerido
4. Importar a sistema
5. Validar con PDF simple

**Ventaja:** Procesa cientos de quinielas en minutos

### Caso 2: Evento Pequeño (10-20 participantes)

**Recomendación:** Registro manual

**Pasos:**
1. Cada participante registra su quiniela desde la web
2. O un administrador las registra una por una
3. Exportar PDF para control

**Ventaja:** Mayor control y validación inmediata

### Caso 3: Reporte de Transparencia

**Objetivo:** Demostrar imparcialidad en resultados

**Pasos:**
1. Exportar PDF simple antes del evento
2. Publicar para que participantes validen sus pronósticos
3. Después del evento, exportar PDF con resultados
4. Publicar ambos PDFs como evidencia

**Ventaja:** Transparencia total del proceso

---

## ⚠️ Limitaciones y Restricciones

### Importación CSV

- Máximo 10MB por archivo
- Sin límite de registros (pero considerar performance)
- Requiere exactamente 72 partidos registrados en BD
- No valida nombres duplicados (permite)
- Procesa línea por línea (si falla una, continúa con las demás)

### Exportación PDF

- Mejor visualización en A3
- En A4 puede ser difícil de leer por densidad de datos
- Máximo recomendado: 500 quinielas por PDF
- Para más de 500, considerar dividir en múltiples PDFs
- Tiempo de generación aumenta con cantidad de registros

### Performance

| Cantidad | Tiempo Importación | Tiempo PDF |
|----------|-------------------|------------|
| 10 quinielas | < 1 segundo | < 2 segundos |
| 50 quinielas | 2-3 segundos | 5 segundos |
| 100 quinielas | 5-7 segundos | 10 segundos |
| 500 quinielas | 30-40 segundos | 60 segundos |

---

## 🛠️ Solución de Problemas

### Error: "El archivo CSV está vacío"

**Causa:** Archivo sin datos o solo con encabezados  
**Solución:** Agregar al menos una fila de datos

### Error: "Debe haber exactamente 72 partidos registrados"

**Causa:** La tabla partidos_72 no tiene 72 registros  
**Solución:** 
```bash
php artisan db:seed --class=Partidos72Seeder
```

### Error: "Se requieren 72 pronósticos"

**Causa:** Una fila del CSV tiene menos de 72 columnas de pronósticos  
**Solución:** Verificar que todas las filas tengan 74 columnas (nombre + teléfono + 72 pronósticos)

### Error: "No se pudo generar el PDF"

**Causa:** Problema con la biblioteca DOMPDF  
**Solución:** Verificar que dompdf esté instalado:
```bash
composer require barryvdh/laravel-dompdf
```

### PDF se ve distorsionado

**Causa:** Demasiados registros o configuración de papel incorrecta  
**Solución:** 
- Reducir cantidad de quinielas por PDF
- Usar papel A3
- Ajustar tamaños de fuente en las vistas

---

## 📊 Ejemplo Completo

### Preparar Datos

```csv
Nombre,Telefono,P1,P2,P3,P4,P5,P6,P7,P8,P9,P10,P11,P12,P13,P14,P15,P16,P17,P18,P19,P20,P21,P22,P23,P24,P25,P26,P27,P28,P29,P30,P31,P32,P33,P34,P35,P36,P37,P38,P39,P40,P41,P42,P43,P44,P45,P46,P47,P48,P49,P50,P51,P52,P53,P54,P55,P56,P57,P58,P59,P60,P61,P62,P63,P64,P65,P66,P67,P68,P69,P70,P71,P72
Juan Perez,555-1234,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E,L,V,E
```

### Importar

1. Guardar como `quinielas.csv`
2. Ir a `/quinielas72`
3. Click "Importar CSV"
4. Seleccionar `quinielas.csv`
5. Click "Importar"
6. Ver reporte de éxito

### Exportar

1. Click "Exportar PDF" → descarga `quinielas_72_2026-05-17_143052.pdf`
2. Calificar partidos
3. Click "PDF con Resultados" → descarga `quinielas_72_resultados_2026-05-17_143125.pdf`

---

## 🎓 Mejores Prácticas

### Para Organizadores

- ✅ Siempre descargar y guardar PDF simple antes del evento
- ✅ Validar importaciones con reporte antes de confirmar
- ✅ Hacer backup de CSVs antes de importar
- ✅ Probar con archivo pequeño antes de importar masivamente
- ✅ Publicar PDF de resultados inmediatamente después de calificar

### Para Participantes

- ✅ Validar pronósticos en PDF antes del evento
- ✅ Guardar comprobante de participación
- ✅ Revisar reporte de resultados publicado

### Para Seguridad

- ✅ Limitar acceso a funciones de importación (solo admins)
- ✅ Registrar todas las importaciones en bitácora
- ✅ Mantener PDFs archivados para auditorías
- ✅ Validar integridad de archivos CSV antes de importar

---

**Última actualización:** Mayo 17, 2026  
**Versión del Sistema:** Laravel 11.x + Livewire 3.x
