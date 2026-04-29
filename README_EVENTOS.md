# Módulo de Eventos

## Propósito
El módulo de eventos permite gestionar eventos dentro del sistema, incluyendo su creación, edición, eliminación y listado. Está diseñado para facilitar la administración de eventos con validaciones robustas y una interfaz interactiva utilizando Livewire.

## Requisitos
- **Laravel**: 13.4.0
- **Livewire**: 3.7.15
- **PostgreSQL**: 17
- **PHP**: >= 8.4.0

## Instalación
1. Clona el repositorio y navega al directorio del proyecto:
   ```bash
   git clone https://github.com/AngelJacobar/gestion-eventos.git
   cd gestion-eventos
   ```
2. Instala las dependencias de PHP y JavaScript:
   ```bash
   composer install
   npm install && npm run dev
   ```
3. Configura el archivo `.env`:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=gestion_eventos
   DB_USERNAME=sail
   DB_PASSWORD=password
   ```
4. Ejecuta las migraciones y seeders:
   ```bash
   php artisan migrate --seed
   ```
5. Configura el alias para Sail (opcional si no está configurado):
   ```bash
   echo "alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'" >> ~/.bashrc
   source ~/.bashrc
   ```
6. Levanta el entorno de desarrollo:
   ```bash
   ./vendor/bin/sail up
   ```

## Uso
### Componentes Principales
- **RegistrarEventoComponent**: Crear y editar eventos.
- **ListarEventosComponent**: Listar y filtrar eventos.
- **EliminarEventoComponent**: Eliminar eventos.

### Validaciones Implementadas
- **Nombre**: Requerido.
- **Fecha de inicio**: Debe ser igual o posterior a hoy.
- **Fecha de fin**: Debe ser igual o posterior a la fecha de inicio.
- **Capacidad**: Debe ser mayor o igual a 1.

### Ejemplo de Request/Response
#### Crear Evento
**Request:**
```json
{
  "nombre": "Congreso Nacional de Tecnología",
  "fecha_inicio": "2026-05-01",
  "fecha_fin": "2026-05-03",
  "lugar": "Centro de Convenciones CDMX",
  "capacidad": 200
}
```
**Response:**
```json
{
  "mensaje": "Evento registrado con éxito."
}
```

#### Validación Fallida
**Request:**
```json
{
  "nombre": "",
  "fecha_inicio": "2026-04-28",
  "fecha_fin": "2026-04-27",
  "capacidad": 0
}
```
**Response:**
```json
{
  "errores": {
    "nombre": ["El campo nombre es obligatorio."],
    "fecha_inicio": ["La fecha de inicio debe ser igual o posterior a hoy."],
    "fecha_fin": ["La fecha de fin debe ser igual o posterior a la fecha de inicio."],
    "capacidad": ["La capacidad debe ser al menos 1."]
  }
}
```

## Próximos Pasos
- Implementar paginación avanzada en el listado de eventos.
- Agregar soporte para exportar eventos a formatos como CSV o PDF.
- Integrar notificaciones en tiempo real para cambios en eventos.

---
Para más información, consulta la [documentación oficial de Laravel](https://laravel.com/docs) y [Livewire](https://livewire.laravel.com).