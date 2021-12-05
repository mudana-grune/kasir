<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;



class CheckIsAdmin
{
    const ADMIN = 2;
    const MANAGER = 3;
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role === self::ADMIN || Auth::user()->role === self::MANAGER ) {
            return $next($request);
        }

        else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}
