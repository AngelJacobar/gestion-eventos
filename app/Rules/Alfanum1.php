<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Alfanum1 implements ValidationRule
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
        $regex = "/^([a-z A-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ\-_\s\d\(\)\.\'\,]+)$/i";

        if (! preg_match($regex, $value)) {
            $fail('validation.alfanum1')->translate();
        }
    }
}
