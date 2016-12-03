<?php

namespace App\Http\Middleware;

use Closure;

class CheckRequestToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasHeader("API-Key") && $request->header("API-Key") == env("API_KEY", "")) {
            return $next($request);
        }

        return response("Not authorized", 401);
    }
}