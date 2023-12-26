<?php

namespace App\Http\Controllers;

use App\Models\bill_payment;
use App\Models\bo;
use App\Models\Deposit;
use App\Models\VirtualAccounts;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Transaction1Controller extends Controller
{
    public function getTransactions()
    {
        $transactions = Deposit::where('username', Auth::user()->username)->selectRaw('DATE(date) as date, SUM(amount) as total_amount')
            ->groupBy('date')
            ->orderBy('date', 'ASC')->limit(15)
            ->get();

        $dates = $transactions->pluck('date')->toArray();
        $amounts = $transactions->pluck('total_amount')->toArray();

        return response()->json([
            'dates' => $dates,
            'amounts' => $amounts,
        ]);
    }
    public function getTransactions1()
    {
        $transactions = WalletTransaction::where('username', Auth::user()->username)->selectRaw('DATE(date) as date, SUM(amount) as total_amount')
            ->groupBy('date')
            ->orderBy('date', 'ASC')->limit(15)
            ->get();

        $dates = $transactions->pluck('date')->toArray();
        $amounts = $transactions->pluck('total_amount')->toArray();

        return response()->json([
            'dates' => $dates,
            'amounts' => $amounts,
        ]);
    }

    function mytransaction()
    {
        $alldepo=Deposit::where('username', Auth::user()->username)->orderBy('id', 'desc')->get();

        return view('transaction', compact('alldepo'));
    }

    function myvirtualaccount()
    {
        $virtual=VirtualAccounts::where('username', Auth::user()->username)->orderBy('id', 'desc')->get();

        return view('virtual', compact('virtual'));
    }




}
