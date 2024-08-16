<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfauthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('accessData')) {
            return redirect()->route('pages.dashboard')->with("error", "Harus Logout Terlebih Dahulu");
        }

        return $next($request);
    }
}
