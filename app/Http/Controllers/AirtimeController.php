<?php

namespace App\Http\Controllers;

use App\Console\encription;
use App\Mail\Emailtrans;
use App\Models\airtimecon;
use App\Models\bill_payment;
use App\Models\bo;
use App\Models\Comission;
use App\Models\data;
use App\Models\User;
use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class AirtimeController
{
    public function loadindex()
    {
        return view('bills.airtime');
    }



    public function airtime(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

            $user = User::find($request->user()->id);

            if ($user->wallet < $request->amount) {
                $mg = "You Cant Make Purchase Above" . "NGN" . $request->amount . " from your wallet. Your wallet balance is NGN $user->wallet. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";

                return response()->json($mg, Response::HTTP_BAD_REQUEST);


            }
            if ($request->amount < 0) {

                $mg = "error transaction";
                return response()->json($mg, Response::HTTP_BAD_REQUEST);



            }
            $bo = bill_payment::where('transactionid', $request->refid)->first();
            if (isset($bo)) {
                $mg = "duplicate transaction kindly reload this page";
                return response()->json( $mg, Response::HTTP_CONFLICT);


            } else {

                $user = User::find($request->user()->id);
                $per=2/100;
                $comission=$per*$request->amount;
                $fbalance=$user->wallet;


                $gt = $user->wallet - $request->amount;

                $user->wallet = $gt;
                $user->save();

                        $bo = bill_payment::create([
                            'username' => $user->username,
                            'product' => $request->id.'Airtime',
                            'amount' => $request->amount,
                            'server_response' => 0,
                            'status' => 0,
                            'number' => $request->number,
                            'paymentmethod'=>'wallet',
                            'transactionid' => $request->refid,
                            'discountamount' => 0,
                            'fbalance'=>$fbalance,
                            'balance'=>$gt,
                        ]);

                $daterserver = new AirtimeserverController();
                $mcd = airtimecon::where('status', "1")->first();
                if ($mcd->server == "mcd"){
                    $response = $daterserver->mcdbill($request);
                    $data = json_decode($response, true);
                    $success = $data["success"];
//                    $tran1 = $data["discountAmount"];
                    if ($success == 1) {

                        $update=bill_payment::where('id', $bo->id)->update([
                            'server_response'=>$response,
                            'status'=>1,
                        ]);
                        $am = "NGN $request->amount  Airtime Purchase Was Successful To";
                        $ph = $request->number;

                        $com=$user->wallet+$comission;
                        $user->wallet=$com;
                        $user->save();

                        $parise=$comission."₦ Commission Is added to your wallet balance";
                        $admin="info@sammighty.com.ng";
                        Mail::to($admin)->send(new Emailtrans($bo));

                        return response()->json([
                            'status' => 'success',
                            'message' => $am.' ' .$ph.' & '.$parise,
                        ]);
                    } elseif ($success == 0) {


                        $am = "NGN $request->amount Was Refunded To Your Wallet";
                        $ph = ", Transaction fail";

                        return response()->json([
                            'status' => 'fail',
                            'message' => $response,
                        ]);
                    }
                }elseif ($mcd->server == "easyaccess"){
                    $response = $daterserver->easyaccess($request);
                    $data = json_decode($response, true);
                    $success = $data["success"];

                    if ($success == "true") {

                        $update=bill_payment::where('id', $bo->id)->update([
                            'server_response'=>$response,
                            'status'=>1,
                        ]);
                        $am = "NGN $request->amount  Airtime Purchase Was Successful To";
                        $ph = $request->number;

                        $com=$user->wallet+$comission;
                        $user->wallet=$com;
                        $user->save();

                        $parise=$comission."₦ Commission Is added to your wallet balance";
                        $admin="info@sammighty.com.ng";
                        Mail::to($admin)->send(new Emailtrans($bo));

                        return response()->json([
                            'status' => 'success',
                            'message' => $am.' ' .$ph.' & '.$parise,
                        ]);
                    } elseif ($success == 0) {


                        $am = "NGN $request->amount Was Refunded To Your Wallet";
                        $ph = ", Transaction fail";

                        return response()->json([
                            'status' => 'fail',
                            'message' => $response,
                        ]);
                    }
                }elseif ($mcd->server == "clubk"){
                    $response = $daterserver->Clubkonnect($request);
                    $data = json_decode($response, true);
                    $success = $data["statuscode"];

                    if ($success == "100") {

                        $update=bill_payment::where('id', $bo->id)->update([
                            'server_response'=>$response,
                            'status'=>1,
                        ]);
                        $am = "NGN $request->amount  Airtime Purchase Was Successful To";
                        $ph = $request->number;

                        $com=$user->wallet+$comission;
                        $user->wallet=$com;
                        $user->save();

                        $parise=$comission."₦ Commission Is added to your wallet balance";
                        $admin="info@sammighty.com.ng";
                        Mail::to($admin)->send(new Emailtrans($bo));

                        return response()->json([
                            'status' => 'success',
                            'message' => $am.' ' .$ph.' & '.$parise,
                        ]);
                    } else{


                        $am = "NGN $request->amount Was Refunded To Your Wallet";
                        $ph = ", Transaction fail";

                        return response()->json([
                            'status' => 'fail',
                            'message' => $response,
                        ]);
                    }
                }

            }
    }

}
