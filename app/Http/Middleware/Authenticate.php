<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('mobile.login'); // Redirect to your login page
        }

        return $next($request);
    }
}
