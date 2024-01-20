<?php

namespace App\Http\Controllers;

use App\Models\Jamb;
use App\Models\waec;
use Illuminate\Support\Facades\Auth;

class EduController
{

    function alledulist()
    {
        $waec=waec::where('username', Auth::user()->username)->get();
        $neco=waec::where('username', Auth::user()->username)->get();
        $nabteb=waec::where('username', Auth::user()->username)->get();
        $jamb=Jamb::where('username', Auth::user()->username)->get();

        return view('education', compact('waec', 'neco', 'nabteb', 'jamb'));
    }
}
