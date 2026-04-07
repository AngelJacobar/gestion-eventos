# Curso Laravel/Livewire 2026 - Repositorio para alumnos

_________________

## Contenido
- [Acerca del proyecto](#acerca-del-proyecto)
- [Instalación](#instalacion)
- [Testing](#testing)

_________________

## Acerca del proyecto {#acerca-del-proyecto}
Este es un proyecto el cual se puede utilizar como base para el desarrollo de aplicaciones web con el framework Laravel 11. 

El proyecto incluye lo siguiente:
- Configuración de Laravel Sail
- Configuración de Laravel Breeze con Blade y Alpine.js
- Implementación del flujo principal de autenticación de usuarios con Laravel Breeze (registro, inicio de sesión, recuperacion de contraseña, cambiar contraseña y cerrar sesión)
- Implementación del flujo principal para administración de usuarios con Laravel Livewire (listar, crear, editar y cambiar estatus de usuarios)
- Implementación del módulo de administración de roles con Laravel Livewire (listar, crear, editar)
- Implementación de autenticación con IDU
- Testing de los flujos de autenticación, administración de usuarios y administración de roles
- Dependencias principales utilizadas:
    *Composer:*
	- [Laravel Breeze](https://laravel.com/docs/11.x/starter-kits#laravel-breeze)
	- [Laravel Livewire](https://livewire.laravel.com/)
	- [Laravel Sail](https://laravel.com/docs/11.x/sail)
	- [Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
	- [Livewire Toaster](https://github.com/masmerise/livewire-toaster)
    
    *NPM:*
    - [Tippy.js](https://atomiks.github.io/tippyjs/)


### Tablas de la base de datos

Las migraciones de laravel incluyen las siguientes tablas:

Tablas creadas por Laravel Breeze:
- usuarios (se renombró originalmente se llamaba users)
- cache
- cache_locks
- failed_jobs
- migrations
- sessions
- jobs
- job_batches

Las tablas propias de la libreria Laravel Permission:
- permissions
- roles
- model_has_permissions
- model_has_roles
- role_has_permissions

Adicionalmente, se agregaron las migraciones para las tablas:
- bitacora
- accion

### Organización del código

Para modularizar la aplicación, los módulos que se desarrollen deben colocarse dentro de la carpeta `modulos/`. Por cada módulo que se desarrolle debe crearse una carpeta con un nombre significativo. Al interior de cada módulo pueden crearse diferentes tipos de clases de acuerdo a los requerimientos de cada módulo, por ejemplo:

- Actions
- Enums
- Filters
- Models
- QueryBuilders
- Exceptions

_________________

## Datos precargados



#### Roles:

- "administrador":
- Permisos:

    - registrar-usuario
    - consultar-listado-usuarios
    - cambiar-estatus-usuario
    - registrar-rol
    - consultar-listado-roles

#### Usuario con rol administrador:

*email*: `admin@mail.com` 
*contraseña*: `password`

_________________

## Instalación {#instalacion}

**Clonación del repositorio en el directorio `proyecto-base-laravel-12/`**

```shell
git clone https://kwira-kaab.unam.mx/DGTIC/DCV/capacitacion/laravel-2026-alumnos.git          
```

**Moverse a la carpeta del proyecto**

```shell
cd laravel-2026-alumnos
```

**Moverse a la rama develop**

```shell
git checkout develop
```

**Ejecutar el siguiente comando para instalar las dependencias y así poder utilizar el comando sail. Este paso es necesario si no se tiene instalado php y composer en el WSL directamente.**

```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

**Crear el archivo .env**

```shell
cp .env.example .env
```

**Asignar los permisos a la carpeta del proyecto**

```shell
cd ..
chmod -R gu+w laravel-2026-alumnos
chmod -R guo+w laravel-2026-alumnos
cd laravel-2026-alumnos
```

**Ejecutar el comando para crear y levantar los servicios**

```shell
sail up -d
```

Si el comando sail no se encuentra debe agregarse el alias al archivo ~/.bashrc

```shell
vi ~/.bashrc
```

Agregar la siguiente linea al final del archivo; moverse al final del archivo, presionar la tecla i y pegar la linea; al finalizar presionar la tecla Esc y escribir :wq para guardar y salir:

```shell
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

**Generar la llave de la aplicación**

```shell
sail artisan key:generate
```

**Instalar las dependencias de javascript**
```shell
sail npm install
```

**Compilar los assets CSS y JS**
```shell
sail npm run dev
```

**Ejecutar las migraciones de laravel**
```shell
sail artisan migrate:fresh --seed
```

**Llegado a este punto ya debe poder ver el proyecto en el navegador en http://localhost**

Posteriormente (por ejemplo después de reiniciar el equipo y se requiera trabajar en el proyecto) se deben ejecutar los comandos:
```shell
sail up -d
sail npm run dev
```
_________________

## Acceder a servicios sail, configurados en docker-compose.yml

- Acceder al contenedor de Apache y PHP:
```
sail bash
```

- Acceder a la base de datos en la terminal:
```
sail psql
```

- Acceder a mailpit desde el navegador:

[http://localhost:8025/](http://localhost:8025/)


- Acceder a meilisearch desde el navegador:

[http://localhost:7700/](http://localhost:7700/)


_________________

## Testing {#testing}

Este proyecto incluye tests para los flujos de autenticación, administración de usuarios y administración de roles.

**Ejecutar los tests**
```shell
sail test
```

**Crear un test**
```shell
sail artisan make:test ExampleTest
```

**Crear un componente de livewire con su respectivo test**
```shell
sail artisan make:livewire ExampleComponent --test
```
