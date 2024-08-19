<?php

namespace CI4CFTurnstile\Validation;

/**
 * TurnstileRules class
 * 
 * Contains validation rules for Cloudflare Turnstile.
 */
class TurnstileRules
{
    /**
     * Validates the Turnstile CAPTCHA response.
     *
     * @param string $str The CAPTCHA response token.
     * @param string|null $error Reference to the error message, if any.
     *
     * @return bool True if validation is successful, false otherwise.
     */
    public function turnstile_verify(string $str, ?string &$error = null): bool
    {
        $service=service('turnstile');
        try{
            if(!$service->verify($str)){
                $error=lang('Turnstile.failed_verification');
                return false;
            }
            return true;
        }catch(\Exception $e){
            $lang=lang('Turnstile.error_' . $e->getCode());
            $error = $lang ?? $e->getMessage();
            return false;
        }
    }
}
