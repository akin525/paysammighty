<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
class TwoFactorController
{
    public function show()
    {
        return view('auth.2fa');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();
        $code = $request->session()->get('2fa_code');

        if ($request->code == $code || $request->code == Cache::get('2fa_code_' . $user->id)) {
            $user->update(['is_two_factor_verified' => true]);
            $request->session()->forget('2fa_code');
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['code' => 'The verification code is incorrect or expired.']);
    }
}
