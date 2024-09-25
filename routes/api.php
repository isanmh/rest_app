<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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
Route::get('test2', [ProductController::class, 'test'])->middleware('auth:sanctum');
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
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('users/logout', [AuthController::class, 'logout']);
    Route::post('user', [AuthController::class, 'user']);
});
