<?php

namespace App\Services;

use Illuminate\Support\Str;

class SignatureServiceTransaction
{
    protected $symmetricKey = "symetrickey";
    protected $accessToken = "TOKEN";
    protected $requestURL = "url";
    protected $httpMethod = "POST";

    public function generateSignature($requestBody)
    {
        $minifiedBody = preg_replace('/\s+/', '', $requestBody);
        $sha256Hash = hash('sha256', $minifiedBody);
        $lowercaseHash = strtolower($sha256Hash);

        $timestamp = now()->format('Y-m-d\TH:i:sP');
        $resultString = $this->httpMethod . ':' . $this->requestURL . ':' . $this->accessToken . ':' . $lowercaseHash . ':' . $timestamp;

        $signature = $this->createSignatureTxn($this->symmetricKey, $resultString);

        return [
            'payload' => $resultString,
            'signature' => $signature,
            'timestamp' => $timestamp,
        ];
    }

    protected function createSignatureTxn($symmetricKey, $resultString)
    {
        $secretKeyHash = hash('sha512', $symmetricKey, true);
        $secretKeyEnc = base64_encode($secretKeyHash);
        return hash_hmac('sha512', $resultString, $secretKeyEnc);
    }
}
