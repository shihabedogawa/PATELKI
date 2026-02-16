<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileComplete
{
    public function handle($request, Closure $next)
{
    $user = auth()->user();

    // jika belum login, biarkan auth middleware urus
    if (!$user) {
        return $next($request);
    }

    // jika bukan member (admin / dll)
    if (!$user->member) {
        return $next($request);
    }

    // jika member belum approved → biarkan login controller
    if ($user->member->status !== 'approved') {
        return $next($request);
    }

    // 🚨 PROFIL BELUM LENGKAP → KUNCI TOTAL
    if (
        !$user->member->is_profile_complete &&
        !$request->routeIs('profile.edit') &&
        !$request->routeIs('profile.update') &&
        !$request->routeIs('logout')
    ) {
        return redirect()->route('profile.edit')
            ->with('warning', 'Lengkapi profil terlebih dahulu untuk melanjutkan.');
    }

    return $next($request);
}

}
