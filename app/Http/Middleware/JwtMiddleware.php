<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    public function handle($request, Closure $next, $roles = '')
    {
        try {
            // Mendapatkan user dari token JWT
            $user = JWTAuth::parseToken()->authenticate();

            // Verifikasi role jika roles tidak kosong
            if (!empty($roles) && !$user->isHasRole($roles)) {
                return response()->json(['error' => 'Anda tidak memiliki credential untuk mengakses data ini'], 403);
            }
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token yang Anda gunakan tidak valid'], 403);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token Anda telah kadaluarsa, silahkan login ulang'], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Silahkan login terlebih dahulu. ' . $e->getMessage()], 403);
        }

        return $next($request);
    }
}
