<?php

namespace CI4CFTurnstile\Config;

use Exception;
use CI4CFTurnstile\Libraries\Verify;

/**
 * Services class for Cloudflare Turnstile integration.
 */
class Services extends \CodeIgniter\Config\Services
{
    /**
     * Returns the Turnstile verification service.
     *
     * @param bool $getShared Whether to return a shared instance.
     *
     * @return Verify The Turnstile verification service.
     * @throws Exception If the Turnstile config or secret is missing.
     */
    public static function turnstile(bool $getShared = true): Verify
    {
        if ($getShared) {
            return static::getSharedInstance(__FUNCTION__);
        }

        $config = config(Turnstile::class);

        if (!$config) {
            throw new Exception(Turnstile::class . ' configuration not found.', 1);
        }

        if (empty($config->secretKey)) {
            throw new Exception('The secret parameter is missing in Turnstile configuration.', 2);
        }

        return new Verify($config->secretKey);
    }
}
