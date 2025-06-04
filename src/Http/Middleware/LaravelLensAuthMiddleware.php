<?php

namespace Odat\LaravelLens\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LaravelLensAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sessionName = config('laravel-lens.session_name');
        if(!session()->has($sessionName)) {
            return redirect()->route('laravel-lens-auth.login');
        }
        return $next($request);
    }
}
