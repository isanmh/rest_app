<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\SignatureTransactionController;
use App\Http\Controllers\TokenApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('testapi', function () {
    return response()->json(['data' => 'Hello World', 'status' => 200],);
});

// Products End points
Route::get('test2', [ProductController::class, 'test'])->middleware('auth:sanctum', 'snap-bi');
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'destroy']);
// Route::patch('products/{id}', [ProductController::class, 'update']);

// authentification & authorization
Route::post('users/register', [AuthController::class, 'register']);
Route::post('users/login', [AuthController::class, 'login']);

// group middleware
// Route::group(['middleware' => ['auth:sanctum', 'snap-bi']], function () {
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('users/logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    // Route::get('products', [ProductController::class, 'index']);
});

// SNAP BI
Route::get('/generate-signature', [SignatureController::class, 'generateSignature']);
Route::post('/send-request', [TokenApiController::class, 'sendRequest']);
Route::get('/generate-signature-transaction', [SignatureTransactionController::class, 'generateSignature']);
