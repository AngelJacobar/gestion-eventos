<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;

class IUnique implements ValidationRule, ValidatorAwareRule
{
    /**
     * The validator instance.
     *
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * Parametros requeridos para realizar la validacion de Unique Case Insensitive
     *
     * [0] => nombre de la tabla
     * [1] => nombre del campo
     * [2] => identificador del registro a ignorar (opcional)
     * [3] => nombre del campo del identificador a ignorar (opcional)
     *
     * @var array
     */
    protected $params = [];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = strtolower($value);

        if (! $this->validator->validateUnique($attribute, $value, $this->params)) {
            $fail('validation.unique')->translate();
        }
    }

    /**
     * Set the current validator.
     */
    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;

        return $this;
    }
}
