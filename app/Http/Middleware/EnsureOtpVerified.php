<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureOtpVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('otp_verified')) {
            return redirect()->route('otp.show');
        }
        return $next($request);
    }
}
