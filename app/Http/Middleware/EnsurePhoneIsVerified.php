<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\MustVerifyPhone;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsurePhoneIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(is_null($request->user()->isPhoneVerified())) {
            return response()->json([
                'message' => 'Your phone number is not verified',
                'verified_phone' => false
            ], 403);
        }

        return $next($request);
    }
}
