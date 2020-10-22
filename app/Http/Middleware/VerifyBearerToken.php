<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class VerifyBearerToken
{
    public function handle($request, Closure $next)
    {
        try {
            $decrypted = Crypt::decryptString($request->bearerToken());
        } catch (DecryptException $e) {
            return response()->json([
                'code' => 0,
                'error' => 'Authorization failed.',
            ], 401);
        }

        if ($decrypted != config('app.key')) {
            return response()->json([
                'code' => 0,
                'error' => 'Authorization failed.',
            ], 401);
        }

        return $next($request);
    }
}
