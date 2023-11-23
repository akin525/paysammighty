<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BillController;
use App\Models\bill_payment;
use App\Models\bo;
use App\Models\data;
use App\Models\easy;
use App\Models\Messages;
use App\Models\refer;
use App\Models\User;
use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AlltvController
{
    public function listtv()
    {

        $tv = easy::where('plan','tv')->get();

        return response()->json([
            'message' => "tv fetch successfuly", 'data' => $tv
        ], 200);

    }

    public function verifytv(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'productid' => 'required',
            'number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $this->error_processor($validator)
            ], 403);
        }
//        return $request;
        $ve=easy::where('plan_id', $request->productid)->first();
//        return $request;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://easyaccess.com.ng/api/verifytv.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'company' =>$ve->code,
                'iucno' => $request->number,
            ),
            CURLOPT_HTTPHEADER => array(
                "AuthorizationToken: fed2524ba6cae4b443f65f60a30a8731", //replace this with your authorization_token
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
//        $success= $data["success"];
//        if($success== "true"){
//            $name=$data["message"]["content"]["Customer_Name"];
//
//            $log=$name;
//        }else{
//            $log= $data["message"];
//        }
        return response()->json([
          'success'=>1, 'message' => $data, 'request'=>$request, 'name'=>$data
        ], 200);


    }
    public function tv(Request $request)
    {

        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        if ($user) {
            $tv = easy::where('plan_id', $request->code)->first();
            return response()->json([
                'message' => "fecthed", 'user'=>$user, 'tv'=>$tv
            ], 200);

        }
        return response()->json([
            'message' => "User not found",
        ], 200);

    }

        public function paytv(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'coded' => 'required',
                'refid' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => BillController::error_processor($validator)
                ], 403);
            }
            $apikey = $request->header('apikey');
            $user = User::where('apikey',$apikey)->first();
            if ($user) {
                $tv = easy::where('plan_id', $request->code)->first();
//                return $tv;



                if ($user->wallet< $tv->tamount) {
                    $mg = "You Cant Make Purchase Above" . "NGN" . $tv->tamount . " from your wallet. Your wallet balance is NGN $user->wallet. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";
                    return response()->json([
                        'message' => $mg, 'user'=>$user
                    ], 200);

                }
                if ($tv->tamount < 0) {

                    $mg = "error transaction";
                    return response()->json([
                        'message' => $mg, 'user'=>$user
                    ], 200);

                }
                $bo = bill_payment::where('transactionid','api'.$request->refid)->first();
                if (isset($bo)) {
                    $mg = "duplicate transaction";
                    return response()->json([
                        'message' => $mg, 'user'=>$user
                    ], 200);

                } else {
                    $gt = $user->wallet - $tv->tamount;


                    $user->wallet = $gt;
                    $user->save();

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://easyaccess.com.ng/api/paytv.php",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_SSL_VERIFYHOST => 0,
                        CURLOPT_SSL_VERIFYPEER => 0,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => array(
                            'company' =>$tv->code,
                            'iucno' => $request['number'],
                            'package' =>$tv['plan_id'],
                        ),
                        CURLOPT_HTTPHEADER => array(
                            "AuthorizationToken: fed2524ba6cae4b443f65f60a30a8731", //replace this with your authorization_token
                            "cache-control: no-cache"
                        ),
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);

//                    return response()->json($response);
                    $data = json_decode($response, true);
                    $success = $data["success"];

                    if ($success == "true") {

                        $bo = bill_payment::create([
                            'username' => $user->username,
                            'product' => $tv->network,
                            'amount' => $tv->tamount,
                            'samount' => $tv->tamount,
                            'server_response' => $response,
                            'status' => 1,
                            'transactionid' =>'api'. $request->refid,
                            'discountamount' => 0,
                            'paymentmethod' => 'wallet',
                            'balance' => $gt,
                        ]);


                        $name = $tv->plan;
                        $am = $tv->network."was Successful to";
                        $ph = $request->number;


                        return response()->json([
                            'user'=>$user, 'name'=>$name, 'am'=>$am, 'ph'=>$ph, 'success'=>$success
                        ], 200);


                    }elseif ($success==0){
                        $zo=$user->wallet+$tv->tamount;
                        $user->wallet = $zo;
                        $user->save();

                        $name= $tv->network;
                        $am= "NGN $request->amount Was Refunded To Your Wallet";
                        $ph=", Transaction fail";
                        return response()->json([
                            'user'=>$user, 'name'=>$name, 'am'=>$am, 'ph'=>$ph, 'success'=>$success
                        ], 200);

                    }
                }
            }
            return response()->json([
                'message' => "User not found",
            ], 200);

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
