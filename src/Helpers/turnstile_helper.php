<?php
// Global Variable to store the registered explicit fields
$turnstile_explicitFields = [];
if (!function_exists('turnstile_implicit')) {
    /**
     * Renders the Turnstile CAPTCHA in implicit mode.
     *
     * @param string $fieldName The name of the form field.
     * @param string $theme The theme of the CAPTCHA ('auto', 'light', 'dark').
     * @param string $size The size of the CAPTCHA ('normal', 'compact').
     *
     * @return string Rendered view for the implicit CAPTCHA.
     * @throws \Exception If the site key is missing.
     */
    function turnstile_implicit(string $fieldName = 'turnstile', string $theme = 'auto', string $size = 'normal'): string
    {
        $config = config(CI4CFTurnstile\Config\Turnstile::class);

        if (empty($config->siteKey)) {
            throw new \Exception('The siteKey parameter is missing.', 3);
        }

        static $inited = false; // Track if the JS script has been initialized
        $callJS = !$inited; // Determine whether to call JS (only on first run)
        $inited = true; // Mark as initialized

        return view('CI4CFTurnstile\Views\turnstile_implicit', [
            'siteKey' => $config->siteKey,
            'fieldName' => $fieldName,
            'theme' => $theme,
            'size' => $size,
            'init' => $callJS // Pass whether to include the JS script
        ]);
    }
}

if (!function_exists('turnstile_explicit')) {
    /**
     * Registers a field for the Turnstile CAPTCHA in explicit mode.
     *
     * @param string $fieldName The name of the form field.
     * @param string $theme The theme of the CAPTCHA ('auto', 'light', 'dark').
     * @param string $size The size of the CAPTCHA ('normal', 'compact').
     *
     * @return void
     */
    function turnstile_explicit(string $fieldName = 'turnstile', string $theme = 'auto', string $size = 'normal'): void
    {
        global $turnstile_explicitFields;

        $turnstile_explicitFields[] = [
            'fieldName' => $fieldName,
            'theme' => $theme,
            'size' => $size,
        ];
    }
}

if (!function_exists('turnstile_explicit_render')) {
    /**
     * Renders the Turnstile CAPTCHA for all registered explicit fields.
     * This function should be called before the closing </body> tag.
     *
     * @return string Rendered JavaScript for the explicit CAPTCHA.
     * @throws \Exception If the site key is missing.
     */
    function turnstile_explicit_render(): string
    {
        global $turnstile_explicitFields;

        if (!empty($turnstile_explicitFields)) {
            $config = config(CI4CFTurnstile\Config\Turnstile::class);

            if (empty($config->siteKey)) {
                throw new \Exception('The siteKey parameter is missing.', 3);
            }

            return view('CI4CFTurnstile\Views\turnstile_explicit', [
                'fields' => $turnstile_explicitFields,
                'siteKey' => $config->siteKey
            ]);
        }
        return '';
    }
}
