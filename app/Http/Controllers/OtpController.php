<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class OtpController extends Controller
{
    public function show()
    {
        return view('auth.otp');
    }

    public function resend(Request $request)
    {
        self::sendOtp($request->user()->email);
        return back()->with('success', 'OTP resent to your email.');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string'
        ]);

        $email = $request->user()->email;
        $cachedOtp = Cache::get("otp_{$email}");

        if (!$cachedOtp || $cachedOtp !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        Cache::forget("otp_{$email}");
        session(['otp_verified' => true]);

        return redirect()->route('dashboard');
    }

    public static function sendOtp($email)
    {
        $otp = rand(100000, 999999);

        Cache::put("otp_{$email}", (string)$otp, now()->addMinutes(5));

        Mail::raw("Your OTP code is: {$otp}", function ($message) use ($email) {
            $message->to($email)->subject("Your Login OTP");
        });
    }
}
