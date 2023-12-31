<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Deposit;
use App\Models\Messages;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController
{
    function loaddashboard()
    {
        $today = Carbon::now()->format('Y-m-d');
        $deposit=Deposit::where('username', Auth::user()->username)->orderBy('id', 'desc')->paginate(25);
        $todaydepo=Deposit::where('username', Auth::user()->username)
            ->where([['created_at', 'LIKE', '%' . $today . '%']])->sum('amount');

        $bus=Business::where('username', Auth::user()->username)->first();
        $me=Messages::where('status', 1)->first();
        return view('dashboard', compact('deposit', 'todaydepo', 'bus', 'me'));


    }

    function mywallet()
    {
        $today = Carbon::now()->format('Y-m-d');
        $pendingbalance=Deposit::where([['created_at', 'LIKE', '%' . $today . '%']])->sum('amount');
        $todaytransaction=Deposit::where([['created_at', 'LIKE', '%' . $today . '%']])->get();
        $wallet=WalletTransaction::where('username', Auth::user()->username)->orderBy('id', 'desc')->get();

        return view('mywallet', compact('pendingbalance', 'todaytransaction','wallet'));
    }
    function myaccount()
    {

        $business=Business::where('username', Auth::user()->username)->first();

        return view('myaccount', compact('business'));
    }

}
