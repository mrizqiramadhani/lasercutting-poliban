<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handles(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('beranda');
        }

        return $next($request);
    }
}
