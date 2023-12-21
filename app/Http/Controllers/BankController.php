<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BankController
{

    function checkbvn($request)
    {

        $amount=100;
        $user = User::where('username', Auth::user()->username)->first();

        if ($user->wallet < $amount) {
            $mg = "You Cant Make Purchase Above" . "NGN" . $amount . " from your wallet. Your wallet balance is NGN $user->wallet. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";

            return response()->json($mg, Response::HTTP_BAD_REQUEST);


        }
        if ($amount < 0) {

            $mg = "error transaction";
            return response()->json($mg, Response::HTTP_BAD_REQUEST);



        }
        $refid='bvn'.rand(10000000, 999999999);
        $bb=$user->wallet;

        $tamount=$bb-100;
        $user->wallet=$tamount;
        $user->save();
        $bf=$tamount;
        $insert=WalletTransaction::create([
            'username'=>$user['username'],
            'source'=>"BVN",
            'amount'=>$amount,
            'refid'=>$refid,
            'bb'=>$bb,
            'bf'=>$bf,
            'status'=>0,
        ]);

        $url = 'https://api.paylony.com/api/v1/bvn_verification';

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . env('PAYLONY')

        );

        $data = array(
            'bvn'=>$request
        );

        $options = array(
            'http' => array(
                'header' => implode("\r\n", $headers),
                'method' => 'POST',
                'content' => json_encode($data),
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);
        if ($data['success']=="true"){
            $fname=$data["data"]['firstname'];
            $lname=$data["data"]['lastname'];

            $name=$fname.' '.$lname;
            $msg=$data['message'];
            $update=WalletTransaction::where('id', $insert->id)->update([
                'status'=>1,
            ]);
            return response()->json([
                'status'=>1,
                'name'=>$name,
                'message'=>$msg
            ]);
        }else{
            $msg=$data['message'];

            return response()->json([
                'status'=>0,
                'name'=>$msg,
                'message'=>$msg
            ]);
        }
    }
    function updatekbvn(Request $request)
    {
        $request->validate([
            'bvn'=>'required',
        ]);

        $user = User::find($request->user()->id);
        $user->bvn=$request['bvn'];
        $user->save();

            return response()->json([
                'status'=>1,
                'message'=>"bvn update successfully"
            ]);

    }
}
