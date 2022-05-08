<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePhoneIsUnverified
{
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->isPhoneVerified()) {
            return \Respond::respondForbidden('Kamu Sudah Terdaftar');
        }

        return $next($request);
    }
}
