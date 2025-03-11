<?php

namespace App\Traits;

use Livewire\Form;

trait UppercaseTransform
{
    public static function formToUppercase(Form $form, ?array $exceptFields = []): Form
    {
        $array = $form->toArray();
        unset($array['validationAttributes']);
        $form->fill(self::arrayToUppercase($array, $exceptFields));

        return $form;
    }

    protected static function arrayToUppercase(array $array, ?array $exceptFields = []): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = self::arrayToUppercase($value, $exceptFields);
            } else {
                if (! in_array($key, [...$exceptFields])) {
                    $array[$key] =
                        isset($value) && $value !== '' && trim($value) !== ''
                        ? mb_strtoupper($value)
                        : null;
                }
            }
        }

        return $array;
    }
}
