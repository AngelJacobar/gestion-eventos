# Importación de Quinielas desde CSV

Esta funcionalidad permite importar múltiples quinielas desde un archivo CSV, facilitando la carga masiva de datos. **Un usuario puede registrar de 1 a 10 quinielas en una sola fila del CSV.**

## 📋 Características

- ✅ Importación masiva de quinielas desde archivo CSV
- ✅ **Soporte para múltiples quinielas por usuario (1-10)**
- ✅ Compatible con exportaciones de Google Forms
- ✅ Validación automática de datos
- ✅ Reporte detallado de importación (éxitos y errores)
- ✅ Detección automática de encoding (UTF-8, ISO-8859-1, Windows-1252)
- ✅ Conversión automática de pronósticos a mayúsculas
- ✅ Transacciones de base de datos para garantizar integridad
- ✅ Nomenclatura automática para distinguir múltiples quinielas del mismo usuario

## 📝 Formato del CSV

El archivo CSV debe tener la siguiente estructura:

### Columnas Requeridas:
1. **Marca temporal** (opcional): Fecha de registro en formato `DD/MM/AAAA HH:MM:SS`
2. **Nombre** (obligatorio): Nombre del participante
3. **Telefono** (opcional): Teléfono de contacto
4. **¿Cuántas quinielas registrarás hoy?** (obligatorio): Número de quinielas a registrar (1-10)
5. **Pronósticos**: 9 columnas por cada quiniela (hasta 90 columnas para 10 quinielas)

### Valores de Pronósticos:
- `L` = Gana el equipo Local
- `V` = Gana el equipo Visitante
- `E` = Empate

### Ejemplo de CSV:

```csv
Marca temporal,Nombre,Telefono,¿Cuántas quinielas registrarás hoy?,P1,P2,P3,P4,P5,P6,P7,P8,P9,P1,P2,P3,P4,P5,P6,P7,P8,P9,P1,P2,P3,P4,P5,P6,P7,P8,P9
4/05/2026 10:00:00,Juan Pérez,5551234567,3,L,V,E,L,V,L,E,V,L,E,L,V,L,E,V,L,V,E,V,L,L,E,V,L,V,L,E
4/05/2026 10:15:00,María García,5559876543,1,V,V,L,E,L,V,L,E,V,,,,,,,,,,,,,,,,,,
4/05/2026 10:30:00,Carlos López,5551122334,2,E,L,V,V,E,L,V,L,E,L,E,V,E,L,V,E,V,L,,,,,,,,,,
```

**Explicación:**
- Juan Pérez registra **3 quinielas**: Se crearán registros como "Juan Pérez - Q1", "Juan Pérez - Q2", "Juan Pérez - Q3"
- María García registra **1 quiniela**: Se creará un registro como "María García"
- Carlos López registra **2 quinielas**: Se crearán registros como "Carlos López - Q1", "Carlos López - Q2"

## 🚀 Cómo Usar

### Paso 1: Preparar el archivo CSV
1. Descarga la plantilla de ejemplo desde el botón "Descargar plantilla de ejemplo" en el modal de importación
2. Llena el archivo con los datos de las quinielas
3. Asegúrate de que los pronósticos sean solo: L, V o E

### Paso 2: Importar el archivo
1. Ve a la sección de **Quinielas**
2. Haz clic en el botón **"Importar CSV"** (ícono de archivo CSV)
3. Selecciona tu archivo CSV
4. Haz clic en **"Importar"**

### Paso 3: Revisar el reporte
El sistema mostrará un reporte con:
- **Registros procesados**: Total de filas procesadas
- **Registros exitosos**: Quinielas importadas correctamente
- **Registros fallidos**: Quinielas con errores
- **Detalles de errores**: Lista de errores encontrados

## ⚠️ Validaciones

El sistema valida automáticamente:

1. **Nombre**: Obligatorio, no puede estar vacío
2. **Cantidad de quinielas**: Debe ser un número entre 1 y 10
3. **Pronósticos**: Deben ser L, V o E (se aceptan mayúsculas y minúsculas)
4. **Formato del archivo**: Debe ser CSV o TXT
5. **Tamaño del archivo**: Máximo 10MB
6. **Estructura**: Debe contener la columna "¿Cuántas quinielas registrarás hoy?"
7. **Quinielas vacías**: Las quinielas sin pronósticos se omiten automáticamente

## 🔍 Campos Generados Automáticamente

El sistema genera automáticamente:

- **Jornada**: Extraída de la marca temporal (formato: `Jornada DD/MM`)
- **Nombre con sufijo**: Si el usuario registra más de 1 quiniela, se agrega " - Q1", " - Q2", etc.
- **Puntaje total**: Inicializado en 0
- **Estatus**: Establecido en 'S' (Activo)
- **Fecha de registro**: Fecha y hora actual del servidor

## 📊 Ejemplo de Resultado

Si importas este CSV:
```csv
4/05/2026 14:19:21,Jacob,5624333938,10,L,L,L,V,L,L,L,L,L,E,V,L,V,L,V,L,V,L,...
```

Se crearán 10 registros en la base de datos:
- Jacob - Q1
- Jacob - Q2
- Jacob - Q3
- Jacob - Q4
- Jacob - Q5
- Jacob - Q6
- Jacob - Q7
- Jacob - Q8
- Jacob - Q9
- Jacob - Q10

## ❌ Errores Comunes

### "El nombre es obligatorio"
- **Causa**: Una fila tiene el campo de nombre vacío
- **Solución**: Asegúrate de que todas las filas tengan un nombre

### "La cantidad de quinielas debe estar entre 1 y 10"
- **Causa**: El valor en la columna de cantidad no está entre 1 y 10
- **Solución**: Verifica que la cantidad sea un número válido

### "Quiniela X - El pronóstico Y debe ser L, V o E"
- **Causa**: Un pronóstico tiene un valor no válido
- **Solución**: Verifica que todos los pronósticos sean L, V o E

### "No se encontró la columna '¿Cuántas quinielas registrarás hoy?'"
- **Causa**: El CSV no tiene la columna de cantidad de quinielas
- **Solución**: Asegúrate de que la columna esté presente en el CSV

## 💡 Consejos

1. **Usa la plantilla**: Descarga la plantilla de ejemplo para asegurarte del formato correcto
2. **Revisa los datos**: Verifica que todos los pronósticos sean válidos antes de importar
3. **Múltiples quinielas**: Si un usuario registra más de 1 quiniela, asegúrate de que haya suficientes columnas de pronósticos
4. **Quinielas incompletas**: Si una quiniela no tiene ningún pronóstico, se omitirá automáticamente
5. **Nomenclatura**: Los registros con múltiples quinielas se nombrarán automáticamente como "Nombre - Q1", "Nombre - Q2", etc.
6. **Archivos grandes**: Para archivos muy grandes, considera dividirlos en lotes más pequeños
7. **Copia de seguridad**: Mantén una copia del archivo original por si necesitas reimportar
8. **Codificación**: Si tienes problemas con caracteres especiales, guarda el archivo en UTF-8

## 🔧 Características Técnicas

- **Transacciones**: Si ocurre un error crítico, todos los cambios se revierten
- **Logging**: Todos los errores se registran en el archivo de logs de Laravel
- **Performance**: Optimizado para importar cientos de quinielas de forma eficiente
- **Encoding**: Detección y conversión automática de codificación de caracteres
- **Procesamiento inteligente**: Detecta automáticamente cuántas quinielas hay por fila
- **Omisión de vacíos**: Las quinielas sin pronósticos se omiten sin generar errores

## 📊 Compatibilidad con Google Forms

Esta funcionalidad está optimizada para trabajar con exportaciones de Google Forms:

1. Crea un formulario en Google Forms con:
   - Campo de texto para "Nombre"
   - Campo de texto para "Teléfono" (opcional)
   - Pregunta numérica "¿Cuántas quinielas registrarás hoy?" (valores del 1 al 10)
   - 9 preguntas de opción múltiple para cada quiniela (opciones: L, V, E)
   - Configura las preguntas de pronósticos para que se repitan según la cantidad de quinielas

2. Exporta las respuestas como CSV desde Google Forms

3. Importa directamente el archivo exportado

El sistema detectará automáticamente:
- La columna de cantidad de quinielas
- Los conjuntos de 9 pronósticos consecutivos
- Creará múltiples registros según la cantidad especificada

### Estructura del Formulario de Google Forms:

```
1. Nombre (Texto corto) - Obligatorio
2. Teléfono (Texto corto) - Opcional
3. ¿Cuántas quinielas registrarás hoy? (Número: 1-10) - Obligatorio
4-12. Partido 1 al 9 - Quiniela 1 (Opción múltiple: L, V, E)
13-21. Partido 1 al 9 - Quiniela 2 (Opción múltiple: L, V, E)
... hasta 10 quinielas (90 preguntas en total)
```

## 📞 Soporte

Si encuentras algún problema durante la importación:
1. Revisa el reporte de errores detallado
2. Verifica el formato del CSV contra la plantilla
3. Consulta los logs del sistema para más detalles técnicos
