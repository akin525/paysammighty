<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\DataserverController;
use App\Mail\Emailtrans;
use App\Models\bill_payment;
use App\Models\data;
use App\Models\easy;
use App\Models\profit;
use App\Models\server;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class BillController
{

    public function data(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'number' => 'required',
            'refid' => 'required',
            'selling_amount'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $this->error_processor($validator)
            ], 403);
        }
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        $bt = easy::where("cat_id", $request->code)->first();

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
                $gt = $user->wallet - $request->selling_amount;

                $fbalance=$user->wallet;

                $bon=$request->selling_amount- $bt->ramount  ;

                $bonus=$user->bonus + $bon;
                $user->wallet = $gt;
                $user->bonus= $bonus;
                $user->save();
                $bo = bill_payment::create([
                    'username' => $user->username,
                    'product' => $bt->network . '|' . $bt->plan,
                    'amount' => $bt->ramount,
                    'samount' => $request->selling_amount,
                    'server_response' => 'ur fault',
                    'status' => 0,
                    'number' => $request->number,
                    'transactionid' =>'api'. $request->refid,
                    'discountamount' => $bon,
                    'paymentmethod' => 'wallet',
                    'fbalance'=>$fbalance,
                    'balance' => $gt,
                ]);

                    $daterserver = new DataserverController();

                        $object = json_decode($bt);
                        $object->number = $request->number;
                        $object->refid = $request->refid;
                        $json = json_encode($object);

                        $mcd = server::where('status', "1")->first();
                        if ($mcd->name == "easyaccess") {
                            $response = $daterserver->easyaccess($object);
//                            return response()->json([
//                                'status' => 'success',
//                                'message' => $response,
//                            ]);
                            $data = json_decode($response, true);
                            $success = "";
                            if ($data['success'] == 'true') {
                                $success = 1;

                                $ms = $data['message'];
                                $po = $bt->ramount - $bt->amount;

                                $profit = profit::create([
                                    'username' => $user->username,
                                    'plan' => $bt->network . '|' . $bt->plan,
                                    'amount' => $po,
                                ]);
                                $update=bill_payment::where('id', $bo->id)->update([
                                    'server_response'=>$response,
                                    'status'=>1,
                                ]);
                                $name = $bt->plan;
                                $am = "$bt->plan  was successful delivered to";
                                $ph = $request->number;


                                $admin="info@sammighty.com.ng";
                                Mail::to($admin)->send(new Emailtrans($bo));

                                return response()->json([
                                    'message' => $am, 'name' => $name, 'ph' => $ph, 'success' => $success,
                                    'user' => $user
                                ], 200);
                            } else {
                                $success = 0;
                                $zo = $user->wallet + $request->amount;
                                $user->wallet = $zo;
                                $user->save();

                                $name = $bt->plan;
                                $am = "NGN $request->amount Was Refunded To Your Wallet";
                                $ph = ", Transaction fail";
                                return response()->json([
                                    'success' => 0,
                                    'message' => $am.' ' .$ph,
                                ]);
                            }
                        }else if ($mcd->name == "mcd") {
                            $response = $daterserver->mcdbill($object);
                            $data = json_decode($response, true);
                            if (isset($data['result'])){
                                $success=$data['result'];
                            }else{
                                $success=$data["success"];
                            }
                            if ($success==1) {
                                $update=bill_payment::where('id', $bo->id)->update([
                                    'server_response'=>$response,
                                    'status'=>1,
                                ]);
                                $name = $bt->plan;
                                $am = "$bt->plan  was successful delivered to";
                                $ph = $request->number;




                                return response()->json([
                                    'message' => $am, 'name' => $name, 'ph' => $ph, 'success' => $success,
                                    'user' => $user
                                ], 200);

                            }elseif ($success==0){
                                $zo=$user->wallet+$request->amount;
                                $user->wallet = $zo;
                                $user->save();

                                $update=bill_payment::where('id', $bo->id)->update([
                                    'server_response'=>$response,
                                    'status'=>0,
                                ]);
                                $name= $bt->plan;
                                $am= "NGN $request->amount Was Refunded To Your Wallet";
                                $ph=", Transaction fail";
                                return response()->json([
                                    'message' => $am, 'name' => $name, 'ph'=>$ph, 'success'=>$success,
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
            array_push($err_keeper, ['success'=> 0, 'code' => $index, 'message' => $error[0]]);
        }
        return $err_keeper;
    }


}



