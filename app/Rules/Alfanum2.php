<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Alfanum2 implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $regex = "/^([a-z A-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\s\d\'\“\”\.\,\;\:\"\‘\’\/\%\#\?\¿\¡\!\-\_\[\]\(\)\$\*\°\=\+\@\&]+)$/i";

        if (! preg_match($regex, $value)) {
            $fail('validation.alfanum2')->translate();
        }
    }
}
