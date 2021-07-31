<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedOrigins = [
            'http://localhost:8080'
        ];
//        return $next($request)
//            ->header('Access-Control-Allow-Origin', 'http://localhost:8080')
//            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE')
//            ->header('Access-Control-Allow-Credentials', 'true')
//            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $requestOrigin = $request->header('origin');
        if (in_array($requestOrigin, $allowedOrigins)) {
            return $next($request)
                ->header('Access-Control-Allow-Origin', $requestOrigin)
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE')
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }
        return $next($request);
    }
}
