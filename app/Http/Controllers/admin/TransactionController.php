<?php

namespace App\Http\Controllers\admin;

use App\Models\bill_payment;
use App\Models\Deposit;
use App\Models\VirtualAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController
{

    function allpaylonytransction()
    {
        $url = 'https://api.paylony.com/api/v1/fetch_all_transfers';

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . env('PAYLONY')
        );
        $options = array(
            'http' => array(
                'header' => implode("\r\n", $headers),
                'method' => 'GET',
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        $data = json_decode($response, true);
        $trans=$data['data']['data'];

//        return $trans;
        return view('admin/paylonytrans', compact('trans'));
    }

    function alldeposit()
    {
        $all=Deposit::all();
        return view('admin/deposits', compact('all'));
    }
    function allvirtual()
    {
        $all=VirtualAccounts::all();
        return view('admin/allvirtual', compact('all'));
    }
    function allvirtualpaylony()
    {
        $url = 'https://api.paylony.com/api/v1/fetch_all_accounts';

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . env('PAYLONY')
        );
        $options = array(
            'http' => array(
                'header' => implode("\r\n", $headers),
                'method' => 'GET',
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        $data = json_decode($response, true);
        $trans=$data['data']['data'];

        return view('admin/payvirtual', compact('trans') );

    }

    function queryindex()
    {
        $sum=deposit::sum('amount');

        return view('admin/depodate', compact('sum'));
    }
    function billdate()
    {
        $sum=bill_payment::sum('amount');

        return view('admin/billdate', compact('sum'));
    }
    function querydeposi(Request $request)
    {
        $request->validate([
            'from'=>'required',
            'to'=>'required',
        ]);

        $deposit=DB::table('deposits')
            ->whereBetween('date', [$request->from, $request->to])->get();
        $sum=deposit::sum('amount');
        $sumdate=DB::table('deposits')
            ->whereBetween('date', [$request->from, $request->to])->sum('amount');

        return view('admin/depodate', ['sum' => $sum, 'sumdate'=>$sumdate, 'deposit'=>$deposit, 'result'=>true]);


    }
    function querybilldate(Request $request)
    {
        $request->validate([
            'from'=>'required',
            'to'=>'required',
        ]);

        $deposit=DB::table('bill_payments')
            ->whereBetween('timestamp', [$request->from, $request->to])->get();
        $sum=bill_payment::sum('amount');
        $sumdate=DB::table('bill_payments')
            ->whereBetween('timestamp', [$request->from, $request->to])->sum('amount');

        return view('admin/billdate', ['sum' => $sum, 'sumdate'=>$sumdate, 'deposit'=>$deposit, 'result'=>true]);


    }
}
