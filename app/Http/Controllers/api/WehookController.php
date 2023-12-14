<?php

namespace App\Http\Controllers\api;


use App\Mail\Emailcharges;
use App\Mail\Emailfund;
use App\Models\Business;
use App\Models\charp;
use App\Models\Deposit;
use App\Models\setting;
use App\Models\User;
use App\Models\VirtualAccounts;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class WehookController
{

    function sendwebhook(Request $request)
    {
        if ($json = json_decode(file_get_contents("php://input"), true)) {
//            print_r($json['reference']);
            $data = $json;

        }
        $refid=$data["reference"];
        $amount=$data["amount"];
        $account=$data['receiving_account'];
        $narration=$data["sender_narration"];
        $virtual = VirtualAccounts::where('account_number', $account)->first();
        $user=User::where('username', $virtual->username)->first();
        $pt=$user['wallet'];

        if ($account== $virtual->account_number ) {
            $depo = Deposit::where('refid', $refid)->first();
            if (isset($depo)) {
                echo "payment refid the same";
            }else {

                $char = setting::first();
                $amount1 = $amount - $char->charges;


                $gt = $amount1 + $pt;
                $reference=$refid;

//                $deposit['narration']=$narration;
                $deposit = Deposit::create([
                    'username' => $user->username,
                    'refid' =>$refid,
                    'amount' => $amount,
                    'iwallet' => $pt,
                    'fwallet' => $gt,
                ]);
                $wt=WalletTransaction::create([
                    'username' => $user->username,
                    'refid' =>$refid,
                    'amount' => $amount,
                    'bb' => $pt,
                    'bf' => $gt,
                ]);
                $user->wallet = $gt;
                $user->save();
                $charp = charp::create([
                    'username' => $user->username,
                    'refid' => $reference,
                    'amount' => $char->charges,
                    'iwallet' => $pt,
                    'fwallet' => $gt,
                ]);


                $admin= 'info@sammighty.com.ng';

                $receiver= $user->email;

                Mail::to($receiver)->send(new Emailfund($deposit));
                Mail::to($admin)->send(new Emailfund($deposit));

                if($user->webhook != null) {

                    $resellerURL = $user->webhook;

                    $response = Http::withOptions([
                        'verify' => false, // Disable SSL verification (use with caution)
                    ])
                        ->post($resellerURL, [
                            'reference' => $refid,
                            'amount' => $amount,
                            'receiving_account' => $account,
//                            'sender_narration' => $narration,
                        ]);

                    $responseBody = $response->body();

                    $statusCode = $response->status();

                    if ($statusCode == 200) {
                        // Successful request
                        return $responseBody;
                    } else {
                        // Handle the error
                        // You might want to log the error or throw an exception
                        return response()->json(['error' => 'Webhook request failed'], $statusCode);
                    }

//                    return $response;
                }




            }


        }


    }
}
