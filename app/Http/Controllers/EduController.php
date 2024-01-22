<?php

namespace App\Http\Controllers;

use App\Models\Jamb;
use App\Models\Nabteb;
use App\Models\neco;
use App\Models\waec;
use Illuminate\Support\Facades\Auth;

class EduController
{

    function alledulist()
    {
        $waec=waec::where('username', Auth::user()->username)->get();
        $neco=neco::where('username', Auth::user()->username)->get();
        $nabteb=Nabteb::where('username', Auth::user()->username)->get();
        $jamb=Jamb::where('username', Auth::user()->username)->get();


        return view('education', compact('waec', 'neco', 'nabteb', 'jamb'));
    }
    function viewjamb($request)
    {
        $jamb=Jamb::where('id', $request)->first();
        return view('edupin', compact('jamb'));
    }
}
