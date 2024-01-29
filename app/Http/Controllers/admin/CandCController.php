<?php

namespace App\Http\Controllers\admin;

use App\Mail\Emailcharges;
use App\Mail\Emailfund;
use App\Models\charp;
use App\Models\Deposit;
use App\Models\setting;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class CandCController
{

public function credit(Request $request)
{
    $request->validate([
        'username' => 'required',
        'amount' => 'required',
        'refid' => 'required',
    ]);
    if (Auth()->user()->role == "admin") {


        $user = User::where('username', $request->username)->first();
        if (!isset($user)){
            $mg='Username not found';
            return response()->json($mg, Response::HTTP_BAD_REQUEST);


        }

        $depo = Deposit::where('refid',$request->refid)->first();
        if (isset($depo)) {
            $mg= 'Duplicate Transaction';
            return response()->json($mg, Response::HTTP_CONFLICT);

        } else {
            $gt = $user->wallet + $request->amount;
            $deposit = Deposit::create([
                'username' => $request->username,
                'refid' => $request->refid,
                'narration'=>'Being Fund By Admin',
                'amount' => $request->amount,
                'iwallet' => $user->wallet,
                'fwallet' => $gt,
            ]);
//            $transaction=WalletTransaction::create([
//                'username'=>$request->username,
//                'activities'=>'Being Fund By Admin',
//            ]);

            $user->wallet = $gt;
            $user->save();
            $admin = 'info@sammighty.com.ng';

            $receiver = $user->email;
            Mail::to($receiver)->send(new Emailfund($deposit));
            Mail::to($admin)->send(new Emailfund($deposit));
            $mo=$request->username." was successful fund with NGN".$request->amount;

            return response()->json(['status'=>'success', 'message'=>$mo]);

        }
    }
    return redirect("admin/login")->with('status', 'You are not allowed to access');


}
public function refund(Request $request)
{
    $request->validate([
        'username' => 'required',
        'amount' => 'required',
    ]);


        $user = User::where('username', $request->username)->first();
        if (!isset($user)){
            $mg='Username not found';
            return response()->json($mg, Response::HTTP_BAD_REQUEST);


        }

            $gt = $user->wallet + $request->amount;

            $user->wallet = $gt;
            $user->save();
            $mo=$request->username." was successful re-fund with NGN".$request->amount;

            return response()->json(['status'=>'success', 'message'=>$mo]);



}
public function fundbonus(Request $request)
{
    $request->validate([
        'username' => 'required',
        'amount' => 'required',
    ]);
    if (Auth()->user()->role == "admin") {


        $user = User::where('username', $request->username)->first();
        if (!isset($user)){
            $mg='Username not found';
            return response()->json($mg, Response::HTTP_BAD_REQUEST);


        }

            $gt = $user->bonus + $request->amount;

            $user->bonus = $gt;
            $user->save();
            $mo=$request->username." bonus was successful fund with NGN".$request->amount;

            return response()->json(['status'=>'success', 'message'=>$mo]);


    }
    return redirect("admin/login")->with('status', 'You are not allowed to access');


}

public function charge(Request $request)
{
    $request->validate([
        'username' => 'required',
        'amount' => 'required',
        'refid' => 'required',
    ]);
    if (Auth()->user()->role == "admin") {
        $user = User::where('username', $request->username)->first();
        if (!isset($user)){

            return response()->json('User not found', Response::HTTP_BAD_REQUEST);

        }


        $gt = $user->wallet - $request->amount;
        $charp = charp::create([
            'username' => $user->username,
            'refid' => $request->refid,
            'amount' => $request->amount,
            'iwallet' => $user->wallet,
            'fwallet' => $gt,
        ]);

        $user->wallet= $gt;
        $user->save();



        $mg=$request->amount . " was charge from " . $request->username . ' wallet successfully';
        return response()->json(['status'=>'success', 'message'=>$mg]);


    }
    return redirect("admin/login")->with('status', 'You are not allowed to access');

}
public function chargebonus(Request $request)
{
    $request->validate([
        'username' => 'required',
        'amount' => 'required',
    ]);
        $user = User::where('username', $request->username)->first();
        if (!isset($user)){

            return response()->json('User not found', Response::HTTP_BAD_REQUEST);

        }


        $gt = $user->bonus - $request->amount;


        $user->bonus= $gt;
        $user->save();



        $mg=$request->amount . " was charge from " . $request->username . ' bonus successfully';
        return response()->json(['status'=>'success', 'message'=>$mg]);


}

}
