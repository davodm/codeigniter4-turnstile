<?php

namespace CI4CFTurnstile\Config;

/**
 * Configuration class for Cloudflare Turnstile.
 */
class Turnstile extends \CodeIgniter\Config\BaseConfig
{
    /**
     * @var string $siteKey The public site key for Turnstile.
     */
    public string $siteKey;

    /**
     * @var string $secretKey The secret key for Turnstile.
     */
    public string $secretKey ;
}
