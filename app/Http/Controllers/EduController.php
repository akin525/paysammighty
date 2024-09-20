<?php

namespace App\Http\Controllers;

use App\Mail\Emailtrans;
use App\Models\bill_payment;
use App\Models\easy;
use App\Models\Jamb;
use App\Models\Nabteb;
use App\Models\neco;
use App\Models\User;
use App\Models\waec;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
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
 function viewnecob()
    {

        return view('education.neco');
    }


    function necobuy(Request $request)
    {


        $user = User::where('username', Auth::user()->username)->first();
        $bt = easy::where("network", "NECO")->first();
        if ($user) {

            if ($user->wallet< $bt->ramount) {
                $mg = "You Cant Make Purchase Above " . "NGN" . $bt->ramount . " from your wallet. Your wallet balance is NGN $user->waller. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";

                return response()->json([
                    'message' => $mg,
                    'user' => $user,
                    'success' => 0
                ], 200);

            }
            if ($bt->ramount < 0) {

                $mg = "error transaction";
                return response()->json([
                    'message' => $mg,
                    'user' => $user,
                    'success' => 0
                ], 200);

            }
            $bo = bill_payment::where('transactionid','api'.$request->refid)->first();;
            if (isset($bo)) {
                $mg = "duplicate transaction";
                return response()->json([
                    'message' => $mg,
                    'user' => $user,
                    'success' => 0
                ], 200);

            } else {
                if (!isset($bt)) {
                    return response()->json([
                        'message' => "invalid code, check and try again later",
                        'user' => $user,
                        'success' => 0
                    ], 200);
                }
                $gt = $user->wallet - $bt->ramount;

                $fbalance=$user->wallet;

                $bon=$bt->ramount  ;

//                $bonus=$user->bonus + $bon;
                $user->wallet = $gt;
//                $user->bonus= $bonus;
                $user->save();
                $bo = bill_payment::create([
                    'username' => $user->username,
                    'product' => $bt->network,
                    'amount' => $bt->ramount,
                    'samount' => $bt->ramount,
                    'server_response' => 'ur fault',
                    'status' => 0,
                    'number' => '0',
                    'transactionid' => $request->refid,
                    'discountamount' => $bon,
                    'paymentmethod' => 'wallet',
                    'fbalance'=>$fbalance,
                    'balance' => $gt,
                ]);

                $wt=WalletTransaction::create([
                    'username' => $user->username,
                    'source'=>$bt->plan,
                    'refid' =>$request->refid,
                    'amount' => $bt->ramount,
                    'bb' => $fbalance,
                    'bf' => $gt,
                ]);
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://easyaccess.com.ng/api/neco_v2.php",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => array(
                        'no_of_pins' =>1,
                    ),
                    CURLOPT_HTTPHEADER => array(
                        "AuthorizationToken: fed2524ba6cae4b443f65f60a30a8731", //replace this with your authorization_token
                        "cache-control: no-cache"
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
//        echo $response;
                $data = json_decode($response, true);
//        return $data;

                if ($data['success']=="true") {
                    $ref=$data['reference_no'];
                    $token=$data['pin'];
//return $token1;

                    $insert=neco::create([
                        'username'=>$user->username,
                        'seria'=>'serial_number',
                        'pin'=>$token,
                        'ref'=>$ref,
                    ]);

                    $mg='Neco Checker Successful Generated, kindly check your pin';
                    $admin="info@sammighty.com.ng";
                    Mail::to($admin)->send(new Emailtrans($bo));
                    $update = bill_payment::where('id', $bo->id)->update([
                        'server_response' => $response,
                        'status' => 1,
                    ]);
                    return response()->json([
                        'message' => $mg.' Token:'.$token, 'success' => 1, 'pin'=>$token,'reference_no'=>$ref,
                        'user' => $user
                    ], 200);
                }elseif($data['success']=="false"){
                    return response()->json([
                        'message' => $response, 'success' => 0,
                        'user' => $user
                    ], 200);
                }
            }



        }else {
            return response()->json([
                'message' => "User not found",
            ], 200);

        }

    }

}
