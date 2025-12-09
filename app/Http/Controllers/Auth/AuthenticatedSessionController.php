<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // ✅ Turnstile verify
use Illuminate\View\View;
use App\Http\Controllers\OtpController; // ✅ OTP controller

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // ✅ Validate Turnstile response exists
        $request->validate([
            'cf-turnstile-response' => ['required'],
        ]);

        // ✅ Verify Turnstile with Cloudflare
        $response = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret'   => config('services.turnstile.secret_key'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(), // optional
            ]
        );

        abort_unless($response->json('success'), 422, 'Captcha failed. Try again.');

        // ✅ Do normal Laravel login (this logs the user in)
        $request->authenticate();

        $request->session()->regenerate();

        // ✅ Send OTP right after successful login
        OtpController::sendOtp($request->user()->email);
        $request->session()->forget('otp_verified');

        // ✅ Redirect to OTP page instead of dashboard
        return redirect()->route('otp.show');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
