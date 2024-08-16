<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('accessData')) {
            return redirect()->route("pages.login")->with('error', 'Anda Harus Login Terlebih Dahulu');
        }

        return $next($request);
    }
}
