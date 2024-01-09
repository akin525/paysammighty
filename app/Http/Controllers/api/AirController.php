<?php

namespace App\Http\Controllers\api;

use App\Console\encription;
use App\Http\Controllers\AirtimeserverController;
use App\Mail\Emailtrans;
use App\Models\airtimecon;
use App\Models\bill_payment;
use App\Models\bo;
use App\Models\Comission;
use App\Models\data;
use App\Models\User;
use App\Models\wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AirController
{
    public function airtime(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'refid' => 'required',
            'amount' => 'required',
            'number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $this->error_processor($validator)
            ], 403);
        }
        $apikey = $request->header('apikey');

        $user = User::where('apikey', $apikey)->first();
        if ($user) {


            if ($user->wallet < $request->amount) {
                $mg = "You Cant Make Purchase Above " . "NGN" . $request->amount . " from your wallet. Your wallet balance is NGN $$user->wallet. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";

                return response()->json([
                    'message' => $mg,
                    'user' => $user,
                    'success' => 0
                ], 200);

            }
            if ($request->amount < 0) {

                $mg = "error transaction";
                return response()->json([
                    'message' => $mg,
                    'user' => $user,
                    'success' => 0
                ], 200);

            }
            $bo = bill_payment::where('transactionid', 'api'.$request->refid)->first();;
            if (isset($bo)) {
                $mg = "duplicate transaction";
                return response()->json([
                    'message' => $mg,
                    'user' => $user,
                    'success' => 0
                ], 200);

            } else {

                $bo=$user->wallet;
                $per = 2 / 100;
                $comission = $per * $request->amount;


                $gt = $user->wallet - $request->amount;


                $user->wallet = $gt;
                $user->save();
                $bo = bill_payment::create([
                    'username' => $user->username,
                    'product' => $request->id . 'Airtime',
                    'amount' => $request->amount,
                    'samount' => $request->amount,
                    'server_response' => 0,
                    'status' => 0,
                    'number' => $request->number,
                    'paymentmethod' => 'wallet',
                    'transactionid' => 'api' . $request->refid,
                    'discountamount' => 0,
                    'balance' => $gt,
                    'fbalance' => $bo,
                ]);

//                $wt=WalletTransaction::create([
//                    'username' => $user->username,
//                    'source'=>"Purchase airtime",
//                    'refid' =>$request->refid,
//                    'amount' => $request->amount,
//                    'bb' => $bo,
//                    'bf' => $gt,
//                ]);
                $daterserver = new AirtimeserverController();
                $mcd = airtimecon::where('status', "1")->first();
                if ($mcd->server == "mcd") {
                    $response = $daterserver->mcdbill($request);
                    $data = json_decode($response, true);
                    $success = $data["success"];
                    if ($success == 1) {

                        $update = bill_payment::where('id', $bo->id)->update([
                            'server_response' => $response,
                            'status' => 1,
                        ]);
                        $com = $user->wallet + $comission;
                        $user->wallet = $com;
                        $user->save();

                        $am = "NGN $request->amount  Airtime Purchase Was Successful To";
                        $ph = $request->number;
                        $admin = "info@sammighty.com.ng";
                        Mail::to($admin)->send(new Emailtrans($bo));

                        return response()->json([
                            'message' => $am, 'ph' => $ph, 'success' => $success,
                            'user' => $user
                        ], 200);
                    } elseif ($success == 0) {

                        $update = bill_payment::where('id', $bo->id)->update([
                            'server_response' => $response,
                            'status' => 0,
                        ]);


//                    $name = $bt->plan;
                        $am = "NGN $request->amount Was Refunded To Your Wallet";
                        $ph = ", Transaction fail";

                        return response()->json([
                            'message' => $am, 'ph' => $ph, 'success' => $success,
                            'user' => $user
                        ], 200);

                    }


                } elseif ($mcd->server == "easyaccess") {
                    $response = $daterserver->easyaccess($request);
                    $data = json_decode($response, true);
                    $success = $data["success"];

                    if ($success == "true") {

                        $update = bill_payment::where('id', $bo->id)->update([
                            'server_response' => $response,
                            'status' => 1,
                        ]);
                        $com = $user->wallet + $comission;
                        $user->wallet = $com;
                        $user->save();

                        $am = "NGN $request->amount  Airtime Purchase Was Successful To";
                        $ph = $request->number;
                        $admin = "info@sammighty.com.ng";
                        Mail::to($admin)->send(new Emailtrans($bo));

                        return response()->json([
                            'message' => $am, 'ph' => $ph, 'success' => $success,
                            'user' => $user
                        ], 200);
                    } else {

                        $update = bill_payment::where('id', $bo->id)->update([
                            'server_response' => $response,
                            'status' => 0,
                        ]);

//                    $name = $bt->plan;
                        $am = "NGN $request->amount Was Refunded To Your Wallet";
                        $ph = ", Transaction fail";

                        return response()->json([
                            'message' => $am, 'ph' => $ph, 'success' => $success,
                            'user' => $user
                        ], 200);
                    }

                } elseif ($mcd->server == "clubk") {
                    $response = $daterserver->Clubkonnect($request);
//                    return $response;

                    $data = json_decode($response, true);
                    $success = $data["status"];

                    if ($success == "ORDER_RECEIVED") {

                        $update = bill_payment::where('id', $bo->id)->update([
                            'server_response' => $response,
                            'status' => 1,
                        ]);
                        $com = $user->wallet + $comission;
                        $user->wallet = $com;
                        $user->save();

                        $am = "NGN $request->amount  Airtime Purchase Was Successful To";
                        $ph = $request->number;
                        $admin = "info@sammighty.com.ng";
                        Mail::to($admin)->send(new Emailtrans($bo));

                        return response()->json([
                            'message' => $am, 'ph' => $ph, 'success' => 1,
                            'user' => $user
                        ], 200);
                    } else {

                        $update = bill_payment::where('id', $bo->id)->update([
                            'server_response' => $response,
                            'status' => 0,
                        ]);

//                    $name = $bt->plan;
                        $am = "NGN $request->amount Was Refunded To Your Wallet";
                        $ph = ", Transaction fail";

                        return response()->json([
                            'message' => $am, 'ph' => $ph, 'success' => 0,
                            'user' => $user
                        ], 200);

                    }

                }
            }
        }else {
            return response()->json([
                'message' => "User not found",
            ], 200);

        }
    }
    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['success'=> '0','code' => $index, 'message' => $error[0]]);
        }
        return $err_keeper;
    }
 }
