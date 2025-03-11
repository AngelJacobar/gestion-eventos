<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validación del idioma
    |--------------------------------------------------------------------------
    |
        | Las siguientes líneas de idioma contienen los mensajes de error predeterminados utilizados por
        | La clase validadora. Algunas de estas reglas tienen múltiples versiones tales
        | como las reglas de tamaño. Siéntase libre de modificar cada uno de estos mensajes aquí.
    |
    */

    'accepted' => 'El campo :attribute debe ser aceptado.',
    'accepted_if' => 'El campo :attribute debe aceptarse cuando :other es :value.',
    'active_url' => 'El campo :attribute no es una URL válida.',
    'after' => 'El campo :attribute debe ser una fecha después de :date.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha después o igual a :date.',
    'alpha' => 'El campo :attribute sólo puede contener letras.',
    'alpha_dash' => 'El campo :attribute sólo puede contener letras, números y guiones.',
    'alpha_num' => 'El campo :attribute sólo puede contener letras y números.',
    'array' => 'El campo :attribute debe ser un arreglo.',
    'ascii' => 'El campo :attribute solo debe contener caracteres alfanuméricos y símbolos de un byte (ascii).',
    'before' => 'El campo :attribute debe ser una fecha antes de :date.',
    'before_or_equal' => 'El campo :attribute debe ser una fecha antes o igual a :date.',
    'between' => [
        'array' => 'El campo :attribute debe tener entre :min y :max elementos.',
        'file' => 'El campo :attribute debe estar entre :min - :max kilobytes.',
        'numeric' => 'El campo :attribute debe estar entre :min - :max.',
        'string' => 'El campo :attribute debe estar entre :min - :max caracteres.',
    ],
    'boolean' => 'El campo :attribute debe ser verdadero o falso.',
    'can' => 'The :attribute field contains an unauthorized value.',
    'confirmed' => 'El campo de confirmación de :attribute no coincide.',
    'current_password' => 'The password is incorrect.',
    'date' => 'El campo :attribute no es una fecha válida.',
    'date_equals' => 'El campo :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El campo :attribute no corresponde con el formato :format.',
    'decimal' => 'El campo :attribute debe tener :decimal decimales.',
    'declined' => 'El campo :attribute debe ser declinado.',
    'declined_if' => 'El campo :attribute debe ser declinado cuando :other es :value.',
    'different' => 'Los campos :attribute y :other deben ser diferentes.',
    'digits' => 'El campo :attribute debe ser de :digits dígitos.',
    'digits_between' => 'El campo :attribute debe tener entre :min y :max dígitos.',
    'dimensions' => 'El campo :attribute no tiene una dimensión válida.',
    'distinct' => 'El campo :attribute tiene un valor duplicado.',
    'doesnt_end_with' => 'El campo :attribute no debe terminar con: :values.',
    'doesnt_start_with' => 'El campo :attribute no debe comenzar con :values.',
    'email' => 'El formato del :attribute no es válido.',
    'ends_with' => 'El campo :attribute debe terminar con alguno de los valores: :values.',
    'enum' => 'El valor seleccionado en :attribute no es válido.',
    'exists' => 'El campo :attribute seleccionado es inválido.',
    'file' => 'El documento :attribute debe ser un archivo.',
    'filled' => 'El campo :attribute es obligatorio.',
    'gt' => [
        'array' => 'El campo :attribute puede tener hasta :value elementos.',
        'file' => 'El campo :attribute debe ser mayor que :value kilobytes.',
        'numeric' => 'El campo :attribute debe ser mayor que :value.',
        'string' => 'El campo :attribute debe ser mayor que :value caracteres.',
    ],
    'gte' => [
        'array' => 'El campo :attribute puede tener :value elementos o más.',
        'file' => 'El campo :attribute debe ser mayor o igual que :value kilobytes.',
        'numeric' => 'El campo :attribute debe ser mayor o igual que :value.',
        'string' => 'El campo :attribute debe ser mayor o igual que :value caracteres.',
    ],
    'image' => 'El campo :attribute debe ser una imagen.',
    'in' => 'El campo :attribute seleccionado es inválido.',
    'in_array' => 'El campo :attribute no existe en :other.',
    'integer' => 'El campo :attribute permite ingresar únicamente números enteros.',
    'ip' => 'El campo :attribute debe ser una dirección IP válida.',
    'ipv4' => 'El campo :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'El campo :attribute debe ser una dirección IPv6 válida.',
    'json' => 'El campo :attribute debe ser una cadena JSON válida.',
    'lowercase' => 'El campo :attribute debe ingresarse en minúsculas.',
    'lt' => [
        'array' => 'El campo :attribute puede tener hasta :max elementos.',
        'file' => 'El campo :attribute debe ser menor que :max kilobytes.',
        'numeric' => 'El campo :attribute debe ser menor que :max.',
        'string' => 'El campo :attribute debe ser menor que :max caracteres.',
    ],
    'lte' => [
        'array' => 'El campo :attribute no puede tener más que :max elementos.',
        'file' => 'El campo :attribute debe ser menor o igual que :max kilobytes.',
        'numeric' => 'El campo :attribute debe ser menor o igual que :max.',
        'string' => 'El campo :attribute debe ser menor o igual que :max caracteres.',
    ],
    'mac_address' => 'El campo :attribute debe ser una dirección MAC válida.',
    'max' => [
        'array' => 'El campo :attribute puede tener hasta :max elementos.',
        'file' => 'El campo :attribute debe tener un máximo de :max kilobytes.',
        'numeric' => 'El campo :attribute debe tener un máximo de :max números.',
        'string' => 'El campo :attribute debe tener un máximo de :max caracteres.',
        'int' => 'El campo :attribute debe tener un máximo de :max.',
    ],
    'max_digits' => 'The :attribute field must not have more than :max digits.',
    'mimes' => 'Solo se permiten archivos con extensión pdf, jpg, jpeg, png, tiff o tif.',
    'mimetypes' => 'El documento :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'array' => 'El campo :attribute debe tener al menos :min elementos.',
        'file' => 'El archivo debe tener al menos :min kilobytes.',
        'numeric' => 'El campo :attribute debe tener al menos :min.',
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
        'int' => 'El campo :attribute debe tener ser mayor a :min.',
    ],
    'min_digits' => 'El campo :attribute debe tener un mínimo :min números.',
    'missing' => 'El campo :attribute no debe estar presente',
    'missing_if' => 'El campo :attribute no debe estar presente cuando :other es :value.',
    'missing_unless' => 'El campo :attribute no debe estar presente a menos que :other es :value.',
    'missing_with' => 'El campo :attribute no debe estar presente cuando exista :values.',
    'missing_with_all' => 'El campo :attribute no debe estar presente cuando existan :values',
    'multiple_of' => 'El campo :attribute debe ser un múltiplo de :value.',
    'not_in' => 'El campo :attribute seleccionado es invalido.',
    'not_regex' => 'El formato del campo :attribute es inválido.',
    'numeric' => 'El campo :attribute permite ingresar únicamente números.',
    'password' => [
        'letters' => 'El campo :attribute debe contener a menos una letra.',
        'mixed' => 'El campo :attribute debe contener al menos una letra mayúscula y una letra minúscula.',
        'numbers' => 'El campo :attribute debe contener al menos un número.',
        'symbols' => 'El campo :attribute debe contener al menos un carácter especial.',
        'uncompromised' => 'El valor ingresado en :attribute ha aparecido en reportes de fuga de información, lo que supone un gran riesgo para esta cuenta. Ingrese un valor distinto.',
        'match' => 'La nueva contraseña no puede ser igual a la contraseña actual.',
    ],
    'present' => 'El campo :attribute debe estar presente.',
    'prohibited' => 'El campo :attribute está prohibido.',
    'prohibited_if' => 'El campo :attribute está prohibido cuando :other es :value.',
    'prohibited_unless' => 'El campo :attribute está prohibido si :other no está en :values',
    'prohibits' => 'El campo :attribute prohibe que :other se encuentre presente.',
    'regex' => 'El formato del campo :attribute es inválido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_array_keys' => 'El campo :attribute debe considerar :values.',
    'required_if' => 'El campo :attribute es obligatorio cuando el campo :other es :value.',
    'required_if_accepted' => 'El campo :attribute es obligatorio cuando se acepta :other.',
    'required_unless' => 'El campo :attribute es obligatorio a menos que :other esté presente en :values.',
    'required_with' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without' => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ningún :values está presente.',
    'same' => 'El campo :attribute y :other debe coincidir.',
    'size' => [
        'array' => 'El campo :attribute debe contener :size elementos.',
        'file' => 'El campo :attribute debe tener :size kilobytes.',
        'numeric' => 'El campo :attribute debe ser :size.',
        'string' => 'El campo :attribute debe tener :size caracteres.',
    ],
    'starts_with' => 'El :attribute debe empezar con uno de los siguientes valores :values',
    'string' => 'El campo :attribute debe ser una cadena.',
    'timezone' => 'El campo :attribute debe ser una zona válida.',
    'unique' => 'El valor del campo :attribute ya se encuentra registrado.',
    'uploaded' => 'Ocurrió un error al subir el archivo. El archivo no debe exceder los 30 MB.',
    'uppercase' => 'El campo :attribute debe ingresarse en mayúsculas.',
    'url' => 'El formato del campo :attribute no es una URL válida.',
    'ulid' => 'El :attribute debe ser un UUID valido.',
    'uuid' => 'El :attribute debe ser un UUID valido.',

    'recaptcha' => 'El :attribute es inválido',
    'current_password' => 'La contraseña actual no es correcta.',
    'same_password' => 'La nueva contraseña no puede ser igual a la contraseña actual.',
    'same_email' => 'El nuevo correo electrónico no puede ser igual al correo electrónico actual.',

    'mixed' => 'El campo :attribute debe contener al menos una letra mayúscula y una letra minúscula.',
    'numbers' => 'El campo :attribute debe contener al menos un número.',
    'symbols' => 'El campo :attribute debe contener al menos un símbolo.',
    'uncompromised' => 'El valor ingresado en :attribute ha aparecido en reportes de fuga de información. Por favor ingrese un valor distinto.',

    'alfanum1' => 'El campo :attribute permite ingresar únicamente letras, números y los siguientes caracteres especiales: acentos, diéresis, apóstrofo o comilla simple, punto, coma, guiones y paréntesis.',
    'alfanum2' => 'El campo :attribute permite ingresar únicamente letras, números y los siguientes caracteres especiales: acentos, acentos graves, diéresis, apóstrofo o comilla simple, punto, coma, punto y coma, dos puntos, comilla doble, diagonal, signo de porcentaje, signo de número, signos de interrogación y de admiración, guiones, corchetes, paréntesis, signo de pesos, asterisco, signo de grado, signo de igualdad, signo de suma, arroba y ampersand.',
    'curp' => 'El formato del campo :attribute no es una CURP válida.',

    /*
    |--------------------------------------------------------------------------
    | Validación del idioma personalizado
    |--------------------------------------------------------------------------
    |
    |   Aquí puede especificar mensajes de validación personalizados para atributos utilizando el
    | convención "attribute.rule" para nombrar las líneas. Esto hace que sea rápido
    | especifique una línea de idioma personalizada específica para una regla de atributo dada.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atributos de validación personalizados
    |--------------------------------------------------------------------------
    |
        | Las siguientes líneas de idioma se utilizan para intercambiar los marcadores de posición de atributo.
        | con algo más fácil de leer, como la dirección de correo electrónico.
        | de "email". Esto simplemente nos ayuda a hacer los mensajes un poco más limpios.
    |
    */

    'attributes' => [
        'email' => 'Correo electrónico',
        'password' => 'Contraseña',
    ],
];
