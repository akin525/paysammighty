<?php

namespace App\Http\Controllers;

use App\Models\waec;
use Illuminate\Support\Facades\Auth;

class EduController
{

    function alledulist()
    {
        $waec=waec::where('username', Auth::user()->username)->get();
        $neco=waec::where('username', Auth::user()->username)->get();
        $nabteb=waec::where('username', Auth::user()->username)->get();
        $jamb=waec::where('username', Auth::user()->username)->get();

        return view('education', compact('waec', 'neco', 'nabteb', 'jamb'));
    }
}
