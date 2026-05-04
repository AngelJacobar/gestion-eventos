# Pruebas Unitarias en el Módulo de Eventos

## Propósito
Las pruebas unitarias nos ayuda a comprobar que las funcionalidades del modulo funcionen poniendolas a prueba en diferentes escenarios tanto existosos como con errores esperadoso los errores esperados.

## Lo que aprendi 
Para poder realizar las pruebas unitarias es necesario usar los seeders para poblar nuestras tablas de datos, para poder crear un evento el usuario debe tener el permiso de crear o registrar evento, por ello se realiza una busqueda de los usuarios que tienen ese rol y se logea. Algo que me llama la atencion es que para poder crear el evento se usa el componente y el nombre del form que se usa tal cual para poder validar los datos .
La función `dispatch` -> Se utiliza para disparar eventos o acciones específicas dentro del sistema, permitiendo que otros componentes o listeners reaccionen a dichos eventos.

La función `assertHasNoErrors` -> Verifica que no existan errores de validación en el formulario o en los datos enviados, asegurando que los datos cumplen con las reglas establecidas.

La función `assertDatabaseHas` -> Comprueba que un registro específico existe en la base de datos, validando que los datos se hayan guardado correctamente después de ejecutar una acción.

## Para crear una prueba unitaria se puede usar el comando 
```bash
sail artisan make:test tests/Features/Livewire/<nombre_modelo>/<nombre_componente>
```
## Ejecución de Pruebas
Para ejecutar una prueba en especifico:
```bash
sail artisan test tests/Feature/Livewire/<nombre_modelo>/<nombre_componente>
```
Para ejecutar las pruebas unitarias, utiliza el siguiente comando:
```bash
sail artisan test
```


## Cobertura de Pruebas
Las pruebas incluyen:
- **RegistrarEventoComponentTest**: Verifica la creación de eventos con datos válidos e inválidos.

## Ejemplo de Prueba
### Registrar Evento Exitoso
```php
#[Test]
    public function crear_evento_exitosamente(): void
    {
        // Dado: un usuario con permiso de registrar-evento autenticado
        Toaster::fake();
        Toaster::assertNothingDispatched();

        $user = $this->usuarioConPermiso('registrar-evento');
        $this->actingAs($user);

        $fechaInicio = now()->addDay()->toDateString();
        $fechaFin    = now()->addDays(3)->toDateString();

        // Cuando: se abre el modal de creación y se envía el formulario con datos válidos
        Livewire::test(RegistrarEventoComponent::class)
            ->dispatch('abrir-modal-registrar-evento', null)
            ->set('form.nombre', 'Congreso Nacional de Tecnología')
            ->set('form.fecha_inicio', $fechaInicio)
            ->set('form.fecha_fin', $fechaFin)
            ->set('form.lugar', 'Centro de Convenciones CDMX')
            ->set('form.capacidad', 200)
            ->call('guardar')
            // Entonces: no hay errores de validación
            ->assertHasNoErrors([
                'form.nombre',
                'form.fecha_inicio',
                'form.fecha_fin',
                'form.lugar',
                'form.capacidad',
            ]);

        // Entonces: el registro existe en la base de datos
        $this->assertDatabaseHas('evento', [
            'nombre'       => 'Congreso Nacional de Tecnología',
            'fecha_inicio' => $fechaInicio,
            'fecha_fin'    => $fechaFin,
            'lugar'        => 'Centro de Convenciones CDMX',
            'capacidad'    => 200,
        ]);

        // Entonces: se muestra el toast de éxito
        Toaster::assertDispatched('eventos.registro.exito');
    }
```

### Validación de Datos Inválidos
```php
#[Test]
    public function no_crea_evento_sin_nombre(): void
    {
        // Dado: un usuario autenticado con permiso de registrar-evento
        $user = $this->usuarioConPermiso('registrar-evento');
        $this->actingAs($user);

        // Cuando: se envía el formulario sin nombre
        Livewire::test(RegistrarEventoComponent::class)
            ->dispatch('abrir-modal-registrar-evento', null)
            ->set('form.nombre', '')
            ->set('form.fecha_inicio', now()->addDay()->toDateString())
            ->set('form.fecha_fin', now()->addDays(3)->toDateString())
            ->set('form.lugar', 'Auditorio Central')
            ->set('form.capacidad', 100)
            ->call('guardar')
            // Entonces: error de validación en el campo nombre (required)
            ->assertHasErrors(['form.nombre' => 'required']);

        // Entonces: no se guarda ningún evento
        $this->assertDatabaseMissing('evento', ['lugar' => 'Auditorio Central']);
    }

```

## Explicación Sencilla
1. **Registrar Evento Exitoso**: Esta prueba verifica que se puede registrar un evento con datos válidos. Se envía una solicitud con datos correctos y se espera que el servidor responda con un código de estado 200 y un mensaje de éxito.
2. **Validación de Datos Inválidos**: Esta prueba asegura que no se puede registrar un evento con datos inválidos (por ejemplo, sin nombre o con fechas incorrectas). El servidor devuelve errores de validación específicos y un código de estado 422.

## ¿Por qué se usa #[Test]?
La anotación `#[Test]` es una característica de PHP 8 que permite marcar métodos como pruebas directamente, sin necesidad de prefijos como `test_` en el nombre del método. Esto hace que el código sea más legible y permite una mejor organización de las pruebas.

## Principio Aplicado
Estas pruebas siguen el principio **AAA (Arrange, Act, Assert)**:
- **Arrange**: Configurar el entorno y los datos necesarios.
- **Act**: Ejecutar la acción que se desea probar.
- **Assert**: Verificar que los resultados sean los esperados.

## Verificación de Documentación
Para más detalles sobre pruebas en Laravel, consulta la [documentación oficial de Laravel sobre pruebas](https://laravel.com/docs/testing).

## Nota Adicional
Si no tienes configurado el alias `sail`, utiliza el siguiente comando para ejecutar las pruebas:
```bash
./vendor/bin/sail artisan test
```