<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // buat logic untuk mengecek header
        $ah = AuthController::header;
        $res1 = $request->header('X-SIGNATURE');
        $res2 = $request->header('X-PARTNER-ID');

        if ($res1 === $ah['X-SIGNATURE'] && $res2 === $ah['X-PARTNER-ID']) {
            return $next($request);
        } else {
            return response()->json([
                'status' => 503,
                'message' => 'Unauthorized & add header',
            ], 503);
        }
    }
}
