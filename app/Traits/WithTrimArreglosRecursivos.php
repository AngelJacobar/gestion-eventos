<?php

namespace App\Traits;

use Livewire\Form;

trait WithTrimArreglosRecursivos
{
    public function trimFormRecursivos(Form $form, ?array $exceptTrimFields = []): Form
    {
        $array = $form->toArray();
        unset($array['validationAttributes']);
        $form->fill($this->trimArreglosRecursivos($array, $exceptTrimFields));

        return $form;
    }

    public function trimArreglosRecursivos(array $arreglo, ?array $exceptTrimFields = []): array
    {
        foreach ($arreglo as $key => $value) {
            if (is_array($value)) {
                $arreglo[$key] = $this->trimArreglosRecursivos($value, $exceptTrimFields);
            } else {
                if (! in_array($key, $exceptTrimFields)) {
                    $arreglo[$key] =
                        isset($value) && $value !== '' && trim($value) !== ''
                        ? preg_replace('/\s+/', ' ', trim($value))
                        : null;
                }
            }
        }

        return $arreglo;
    }
}
