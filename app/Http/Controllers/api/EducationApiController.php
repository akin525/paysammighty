<?php

namespace App\Http\Controllers\api;

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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;


class EducationApiController
{
    function Nabteb(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'refid' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $this->error_processor($validator)
            ], 403);
        }
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        $bt = easy::where("network", "Nabteb")->first();
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
                    'product' => $bt->network,
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
                    CURLOPT_URL => "https://easyaccess.com.ng/api/nabteb_v2.php",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => array(
                        'no_of_pins' =>$request->value,
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

                    $insert=Nabteb::create([
                        'username'=>$user->username,
                        'seria'=>'serial_number',
                        'pin'=>$token,
                        'ref'=>$ref,
                    ]);

                    $mg='Nabteb Checker Successful Generated, kindly check your pin';
                    $admin="info@sammighty.com.ng";
                    Mail::to($admin)->send(new Emailtrans($bo));

                    return response()->json([
                        'message' => $mg, 'success' => 1, 'pin'=>$token,'reference_no'=>$ref,
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
    function Jamb(Request $request)
    {
        $request->validate([
            'number'=>'required',
            'refid'=>'required',
        ]);
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        $bt = easy::where("network", "Jamb")->first();
        if ($user) {

            if ($user->wallet < $bt->ramount) {
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
            $bo = bill_payment::where('transactionid', 'api' . $request->refid)->first();;
            if (isset($bo)) {
                $mg = "duplicate transaction";
                return response()->json([
                    'message' => $mg,
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
                'product' => $bt->network,
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
            $wt=WalletTransaction::create([
                'username' => $user->username,
                'source'=>$bt->plan,
                'refid' =>$request->refid,
                'amount' => $bt->ramount,
                'bb' => $fbalance,
                'bf' => $gt,
            ]);
            $userId ='CK100308875';
            $apiKey ='961MT1M6C4DD542FL648614W41Q2OLDERYYOQMK6M66XZC2DPPP6671064N8TB94';
            $examCode = 'utme';
            $recipientPhoneNo = $request['number'];
            $requestId = 'request_id';
            $callbackUrl = 'https://pay.sammighty.com.ng/api/callback_url';

            $url = "https://www.nellobytesystems.com/APIJAMBV1.asp?UserID=$userId&APIKey=$apiKey&ExamType=$examCode&PhoneNo=$recipientPhoneNo&CallBackURL=$callbackUrl";


            $options = array(
                'http' => array(
                    'method' => 'GET',
                ),
            );

            $context = stream_context_create($options);
            $responseBody= file_get_contents($url, false, $context);

            $data = json_decode($responseBody, true);

            if ($data["status"] =="ORDER_COMPLETED"){
                $ref=$data['Serial No'];
                $token=$data['pin'];
                $insert=Jamb::create([
                    'username'=>$user->username,
                    'serial'=>$data['Serial No'],
                    'pin'=>$token,
                    'response'=>$data,
                ]);

                $mg='Jamb Pin Successful Generated, kindly check your pin: '.$token;
                $admin="info@sammighty.com.ng";
                Mail::to($admin)->send(new Emailtrans($bo));

                return response()->json([
                    'message' => $mg, 'success' => 1,
                    'user' => $user
                ], 200);

            }else{

                return response()->json([
                    'status' => 'fail',
                    'message' => $data,
                    'success' => 0
                ]);
            }



        }



    }
    function Waec(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'refid' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $this->error_processor($validator)
            ], 403);
        }
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        $bt = easy::where("network", "WAEC")->first();
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
                    'product' => $bt->network,
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
                    CURLOPT_URL => "https://easyaccess.com.ng/api/waec_v2.php",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => array(
                        'no_of_pins' =>$request->value,
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

                    $insert=waec::create([
                        'username'=>$user->username,
                        'seria'=>'serial_number',
                        'pin'=>$token,
                        'ref'=>$ref,
                    ]);

                    $mg='Waec Checker Successful Generated, kindly check your pin';
                    $admin="info@sammighty.com.ng";
                    Mail::to($admin)->send(new Emailtrans($bo));

                    return response()->json([
                        'message' => $mg, 'success' => 1, 'pin'=>$token,'reference_no'=>$ref,
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
    function Neco(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'refid' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $this->error_processor($validator)
            ], 403);
        }
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
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
                $gt = $user->wallet - $request->selling_amount;

                $fbalance=$user->wallet;

                $bon=$request->selling_amount- $bt->ramount  ;

                $bonus=$user->bonus + $bon;
                $user->wallet = $gt;
                $user->bonus= $bonus;
                $user->save();
                $bo = bill_payment::create([
                    'username' => $user->username,
                    'product' => $bt->network,
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
                        'no_of_pins' =>$request->value,
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

                    return response()->json([
                        'message' => $mg, 'success' => 1, 'pin'=>$token,'reference_no'=>$ref,
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
    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['success'=> 0, 'code' => $index, 'message' => $error[0]]);
        }
        return $err_keeper;
    }

}
