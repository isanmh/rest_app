<?php

namespace App\Http\Controllers;

use App\Services\SignatureServiceTransaction;
use Illuminate\Http\Request;

class SignatureTransactionController extends Controller
{
    protected $signatureServiceTransaction;

    public function __construct(SignatureServiceTransaction $signatureServiceTransaction)
    {
        $this->signatureServiceTransaction = $signatureServiceTransaction;
    }

    public function generateSignature(Request $request)
    {
        $requestBody = json_encode([
            'fromDateTime' => '2024-08-11T07:00:00+07:00',
            'toDateTime' => '2024-08-11T23:30:00+07:00',
            'pageNumber' => 1,
        ]);

        $result = $this->signatureServiceTransaction->generateSignature($requestBody);

        return response()->json($result);
    }
}
