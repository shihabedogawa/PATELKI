<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDivision
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $division)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->division !== $division) {
        abort(403, 'Anda tidak memiliki akses ke divisi ini.');
    }

    return $next($request);
}



    
}
