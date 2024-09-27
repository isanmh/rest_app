<?php

namespace App\Services;

class SignatureService
{
    // protected $privateKeyString = "DXmW91iyRxWTtqCoYty65MaMSIaya70I0vUK7fhMr4o=";
    // protected $clientKey = "client key";
    protected $privateKeyString = <<<EOD
    -----BEGIN PRIVATE KEY-----
    XXXXXXXXXXX
    -----END PRIVATE KEY-----
    EOD;
    protected $clientKey = "5e349e20641d43db909d6e2019c99311=";

    public function generateSignature()
    {
        $timestamp = now()->format('Y-m-d\TH:i:sP');
        $stringToSign = $this->clientKey . "|" . $timestamp;

        $privateKey = openssl_pkey_get_private($this->privateKeyString);
        if (!$privateKey) {
            return ['error' => 'Private key not valid'];
        }

        $signature = '';
        if (!openssl_sign($stringToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
            return ['error' => 'Failed to sign data'];
        }

        return [
            'signature_hex' => bin2hex($signature),
            'timestamp' => $timestamp,
        ];
    }
}
