<?php

namespace CI4CFTurnstile\Libraries;
use Exception;

/**
 * Class Verify
 * 
 * Handles verification of Cloudflare Turnstile CAPTCHA.
 */
class Verify
{
    private string $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * Verifies the Turnstile response token.
     *
     * @param string $token The Turnstile response token.
     * @param string|null $ip The IP address of the user (optional).
     *
     * @return bool True if the verification is successful, false otherwise.
     * @throws Exception If the token is missing.
     */
    public function verify(string $token,string $ip=null): bool
    {
        if(empty($token)){
            throw new Exception('Token is required to verify Turnstile response',5);
        }

        if(empty($ip)){
            $req = service('request');
            // Fetch the IP address from Cloudflare first, if available
            $ip = $req->getHeaderLine('CF-Connecting-IP') ?? $req->getIPAddress();
        }

        $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

        $client = \Config\Services::curlrequest();

        try{
            $response = $client->request('POST',$url,[
                'headers'=>[
                    'Accept'=>'application/json',
                ],
                'json'=>[
                    'secret' => $this->secret,
                    'response' => $token,
                    'remoteip' => $ip,
                ],
            ]);
        }catch (\CodeIgniter\HTTP\Exceptions\HTTPException $e){
            throw new Exception('Failed to verify Turnstile response: '.$e->getMessage(),10);
        }

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Failed to verify Turnstile response, status code: ' . $response->getStatusCode(),10);
        }

        $result = json_decode($response->getBody(), true);

        return isset($result['success']) && $result['success'] === true;
    }
}
