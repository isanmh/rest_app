<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TokenApiController extends Controller
{
    public function sendRequest()
    {
        $response = Http::withHeaders([
            'X-CLIENT-KEY' => '5e349e20641d43db909d6e2019c99311',
            'X-TIMESTAMP' => '2020-01-01T00:00:00+07:00',
            'X-SIGNATURE' => 'dBVUG2S2PlpfN/L4pxm5p7ypfni9cEQml6Mir38HvhaJbvM4YAx3G+kdSW1/QuUi+b1BbFcYueTEg4oKO4QrOg7P4pfca1/vnk47NT2RCzOvX1rt/A6Osq9g4aLJ8bOXtxUwfl4r+UU5/OwhKwLB4yK5Szs4ze6SZsjZsKTLaCldGzE7GaxxSFkRm/urf2cm5gp18UXZuRsJP2n6RoiN0U2C/UsW58oeApP0FhbSM5a+Vi/QD/NlIC5MwqnpFTB4QRaTxU5nBQE2kgFnHQrFkgJo5U5ynQR7r+zGDKMLLzJFpw2vP/SVW6juWrhVw82cXqzfXS+aD+4itZ580MRDZg==',
            'Private-Key' => 'DXmW91iyRxWTtqCoYty65MaMSIaya70I0vUK7fhMr4o=',
            'Content-Type' => 'application/json',
        ])->post('https://apidevportal.aspi-indonesia.or.id:44310/api/v1.0/access-token/b2b', [
            'grantType' => 'client_credentials',
            'additionalInfo' => new \stdClass(),
        ]);

        return $response->json();
    }
}
