# Instrucciones para Poblar la Base de Datos

Este script de Python pobla automáticamente todas las tablas de la base de datos del sistema de gestión de eventos con datos de ejemplo.

## Requisitos Previos

1. **Docker/Laravel Sail activo** - El contenedor de PostgreSQL debe estar corriendo
2. **Python 3.8+** instalado en tu sistema
3. **Paquetes del sistema** para entornos virtuales de Python

### Instalación de Python (si no lo tienes)

**Ubuntu/Debian/WSL:**
```bash
sudo apt update
sudo apt install -y python3 python3-pip python3-venv python3-full
```

**macOS:**
```bash
# Si tienes Homebrew instalado
brew install python3
```

**Windows:**
- Descarga e instala desde [python.org](https://www.python.org/downloads/)
- Durante la instalación, marca la opción "Add Python to PATH"

### Verificar instalación de Python

```bash
python3 --version
# Debe mostrar: Python 3.8 o superior
```

## Configuración del Entorno Virtual (venv)

El entorno virtual aísla las dependencias de Python para este proyecto, evitando conflictos con otros proyectos.

### 1. Crear el entorno virtual (solo la primera vez)

```bash
# Dentro del directorio del proyecto laravel-2026-alumnos
python3 -m venv venv
```

Esto crea una carpeta `venv/` con una instalación aislada de Python.

### 2. Activar el entorno virtual

**Linux/macOS/WSL:**
```bash
source venv/bin/activate
```

**Windows (PowerShell):**
```powershell
venv\Scripts\Activate.ps1
```

**Windows (CMD):**
```cmd
venv\Scripts\activate.bat
```

**Verificar que está activo:**
- Tu terminal debe mostrar `(venv)` al inicio del prompt
- Ejemplo: `(venv) user@host:~/laravel-2026-alumnos$`

### 3. Instalar las dependencias de Python

Con el entorno virtual activo, instala las dependencias:

```bash
pip install -r requirements.txt
```

**Nota:** Ya no necesitas `pip3` ni `sudo`, solo `pip` cuando el venv está activo.

### 4. Desactivar el entorno virtual (cuando termines)

```bash
deactivate
```

## Ejecución del Script

1. **Asegúrate de que Laravel Sail esté corriendo:**
   ```bash
   ./vendor/bin/sail up -d
   ```

2. **Ejecuta las migraciones y seeders:**
   ```bash
   ./vendor/bin/sail artisan migrate:fresh --seed
   ```
   
   **Nota:** El `--seed` es importante porque crea los roles necesarios (Invitado, Asistente, Organizador).

3. **Activa el entorno virtual de Python:**
   ```bash
   source venv/bin/activate
   ```

4. **Ejecuta el script de poblado:**
   ```bash
   python poblar_base_datos.py
   ```
   
   **Comando completo (en una línea):**
   ```bash
   source venv/bin/activate && python poblar_base_datos.py
   ```

5. **Desactiva el entorno virtual (opcional):**
   ```bash
   deactivate
   ```

## ¿Qué hace el script?

El script poblará las siguientes tablas con datos realistas:

- **300 usuarios** con emails @example.com, CURP, números de cuenta y trabajador
- **30 eventos** con nombres, fechas, lugares y capacidades variadas
- **150 sesiones** (5 por evento) con 40 ponentes diferentes y 25 lugares
- **15 preguntas** estándar de satisfacción (catálogo fijo aplicable a todos los eventos)
- **~6,300 inscripciones** de usuarios a eventos (70% de los usuarios)
- **~57,000 respuestas** de encuestas de satisfacción (los asistentes responden la mayoría de preguntas)

## Credenciales de Prueba

Todos los usuarios creados tienen la misma contraseña para facilitar las pruebas:

- **Email:** cualquier email generado (ejemplo: `juan.lopez0@example.com`)
- **Password:** `password`

## Configuración Personalizada

Puedes modificar las cantidades en el archivo `poblar_base_datos.py`:

```python
CANTIDAD_USUARIOS = 300         # Número de usuarios a crear
CANTIDAD_EVENTOS = 30           # Número de eventos
SESIONES_POR_EVENTO = 5         # Sesiones por cada evento
PORCENTAJE_ASISTENCIA = 0.7     # 70% de usuarios se inscriben
```

**Nota:** Las preguntas de satisfacción son un catálogo estándar fijo de 15 preguntas que se aplican a todos los eventos.

## Características del Script

✓ Genera datos realistas en español (México)  
✓ Respeta todas las relaciones de foreign keys  
✓ Limpia las tablas antes de poblar  
✓ **Rollback automático** en caso de error (no se guardan cambios parciales)  
✓ Catálogo estándar de 15 preguntas de satisfacción para todos los eventos  
✓ 40 ponentes diferentes y 25 lugares para mayor variedad  
✓ Respuestas inteligentes según el tipo de pregunta (escala 1-10, Sí/No, calidad, opinión)  
✓ Maneja errores y muestra un resumen al final  
✓ Usa bcrypt para hashear las contraseñas  
✓ Genera CURPs, emails @example.com, números de cuenta, etc.  

## Solución de Problemas

### Error de conexión a la base de datos

Si obtienes un error de conexión, verifica que:
- Laravel Sail esté corriendo: `./vendor/bin/sail ps`
- El puerto 5432 esté mapeado correctamente
- Las credenciales en `.env` coincidan con las del script

### Problemas con psycopg2

Si hay problemas instalando `psycopg2`, instala las dependencias del sistema:

**Ubuntu/Debian:**
```bash
sudo apt-get install python3-dev libpq-dev
```

**macOS:**
```bash
brew install postgresql
```

**Alternativa:** Usa `psycopg2-binary` que ya está en `requirements.txt`

## Volver a Poblar

Si quieres limpiar y volver a poblar la base de datos:

```bash
# Las migraciones limpian todo
./vendor/bin/sail artisan migrate:fresh

# Luego ejecuta el script de nuevo
python3 poblar_base_datos.py
```

## Notas

- El script es **idempotente**: limpia las tablas antes de insertar datos
- Los datos son **aleatorios**: cada ejecución genera datos diferentes
- Las fechas de eventos están en el **futuro** (próximo año)
- Las contraseñas están hasheadas con **bcrypt** como Laravel lo requiere
