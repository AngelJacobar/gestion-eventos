<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReCaptcha implements ValidationRule
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
        if (! config('services.recaptcha.enable')) {
            return;
        }
        if ($value === null || $value === '') {
            $fail('validation.required')->translate(['attribute' => 'reCaptcha']);
            return;
        }
        try {
            $captchaResponse = Http::asForm()->post(config('services.recaptcha.verify_url'), [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $value,
            ])->json();
        } catch (\Exception $e) {
            Log::error($e::class . ' > ' . $e->getFile() . '('.$e->getLine().'): ' . $e->getMessage());
            $captchaResponse['success'] = false;
            $captchaResponse['error-codes']['0'] = $e->getMessage();
        }

        if ($captchaResponse['success'] !== true) {
            $errorCode = $captchaResponse['error-codes']['0'] ?? '';
            // todavia esta con el anterior recaptcha
            if ($errorCode === 'timeout-or-duplicate') {
                return;
            }
            $fail('validation.recaptcha')->translate(['attribute' => 'reCaptcha']);
        }
    }
}
