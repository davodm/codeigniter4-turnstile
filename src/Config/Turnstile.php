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
    public string $siteKey = '';

    /**
     * @var string $secretKey The secret key for Turnstile.
     */
    public string $secretKey = '';

    /**
     * Constructor for Turnstile configuration.
     *
     * Loads the site key and secret key from environment variables.
     */
    public function __construct()
    {
        $this->siteKey = getenv('cloudflare.turnstile.sitekey');
        $this->secretKey = getenv('cloudflare.turnstile.secretkey');

        // Optionally, validate the keys
        if (empty($this->siteKey) || empty($this->secretKey)) {
            throw new \Exception('The siteKey and secretKey parameters are required.', 4);
        }
    }
}
