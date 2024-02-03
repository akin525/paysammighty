<?php

namespace App\Http\Controllers\admin;

use App\Models\bill_payment;
use App\Models\Business;
use App\Models\Deposit;
use App\Models\reverse;
use App\Models\User;
use App\Models\VirtualAccounts;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    function allpurchase()
    {
        $purchase=bill_payment::all();

        return view('admin/allbills', compact('purchase'));
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
    function findtrans(Request $request)
    {
        $purchase="";
            $bu="";
            $user="";
            $pass=1;

        return view('admin/finddpurchase',compact('purchase', 'user', 'pass'));
    }
    function findtransaction(Request $request)
    {
        $purchase=bill_payment::where('transactionid', $request->refid)->first();
        if ($purchase != null){
            $user=User::where('username', $purchase->username)->first();
            $bu=Business::where('username', $purchase->username)->first();
            $user['number']=$bu->phone;
            $pass=1;
        }else{
            $user="";
            $pass=0;
        }

        return view('admin/finddpurchase',compact('purchase', 'user', 'pass'));
    }
    function checktransaction($request)
    {
        $purchase=bill_payment::where('id', $request)->first();
        if ($purchase != null){
            $user=User::where('username', $purchase->username)->first();
            $bu=Business::where('username', $purchase->username)->first();
            $user['number']=$bu->phone;
            $pass=1;
        }else{
            $user="";
            $pass=0;
        }

        return view('admin/checkpurchase',compact('purchase', 'user', 'pass'));
    }
    function reversedtransaction($request)
    {
        $bills=bill_payment::where('id', $request)->first();

        $check=reverse::where('transactionid', $bills->transactionid)->first();
        if (isset($check)){
            $mg = "Transaction already reversed";
            return response()->json( $mg, Response::HTTP_CONFLICT);
        }
        $re=reverse::create([
            'username' => $bills->username,
            'product' => 'data|' . $bills->plan,
            'amount' => $bills->amount,
            'samount' => $bills->samount,
            'server_response' => 'reversed transaction',
            'status' => "Reversed",
            'number' => $bills->number,
            'transactionid' => $bills->transactionid,
            'discountamount'=>0,
            'paymentmethod'=> 'wallet',
            'fbalance'=>$bills->fbalance,
            'balance'=>$bills->balance,
        ]);

        $user=User::where('username', $bills->username)->first();
        $bal=$bills->amount+$user->wallet;
            $user->wallet=$bal;
            $user->save();

            $bills->status="Reversed";
            $bills->save();
            $msg="Transaction Reverse Successful";
            return response()->json([
                'status'=>1,
                'message'=>$msg,
            ]);
    }
    function reversedmark($request)
    {
        $bills=bill_payment::where('id', $request)->first();

        $check=reverse::where('transactionid', $bills->transactionid)->first();
        if (isset($check)){
            $mg = "Transaction already reversed";
            return response()->json( $mg, Response::HTTP_CONFLICT);
        }
        $re=reverse::create([
            'username' => $bills->username,
            'product' => 'data|' . $bills->plan,
            'amount' => $bills->amount,
            'samount' => $bills->samount,
            'server_response' => 'reversed transaction',
            'status' => "Reversed",
            'number' => $bills->number,
            'transactionid' => $bills->transactionid,
            'discountamount'=>0,
            'paymentmethod'=> 'wallet',
            'fbalance'=>$bills->fbalance,
            'balance'=>$bills->balance,
        ]);

        $user=User::where('username', $bills->username)->first();
//        $bal=$bills->amount+$user->wallet;
//            $user->wallet=$bal;
//            $user->save();

            $bills->status="Reversed";
            $bills->save();
            $msg="Transaction Reverse Successful";
            return response()->json([
                'status'=>1,
                'message'=>$msg,
            ]);
    }

}
