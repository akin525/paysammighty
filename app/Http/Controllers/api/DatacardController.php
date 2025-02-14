<?php


namespace App\Http\Controllers\api;


use App\Mail\Emailtrans;
use App\Models\bill_payment;
use App\Models\easy;
use App\Models\Giftbills;
use App\Models\profit;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DatacardController
{

    public function list(Request $request)
    {


        $request->validate([
            'pro'=>'required',
            'provider'=>'required',
        ]);
        $auth = env('GIFTBILLS');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://giftbills.com/api/v1/internet/plans/'.$request->provider,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$auth,
                'MerchantId: '.env('GIFTBILLS_MID'),
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
//        return $response;

        $data1 = json_decode($response, true);
        $data=$data1['data'];

//return $success;
        foreach ($data as $plan){
            $success =$request->provider;
            $planid = $plan["id"];
            $price= $plan['amount'];
            $catid=$plan['data_type_id'];
            $validity =$plan['name'];
            $code=$plan['data_type_id'];
            $insert= Giftbills::create([
                'plan_id' =>$planid,
                'network' =>$success,
                'plan' =>$validity,
                'code' =>$code,
                'amount'=>$price,
                'tamount'=>$price,
                'ramount'=>$price,
                'cat_id'=>$planid,
            ]);
        }

        return $data1;

//    return view('pam', compact('product'));


    }



    function datacardpurchase(Request $request)
    {


        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        $bt = easy::where("network", 'DATACARD')->first();

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

            } else {
                if (!isset($bt)) {
                    return response()->json([
                        'message' => "invalid code, check and try again later",
                        'user' => $user,
                        'success' => 0
                    ], 200);
                }
                $gt = $user->wallet - $request->selling_amount;

                $fbalance = $user->wallet;

                $bon = $request->selling_amount - $bt->ramount;

                $bonus = $user->bonus + $bon;
                $user->wallet = $gt;
                $user->bonus = $bonus;
                $user->save();

                $bo = bill_payment::create([
                    'username' => $user->username,
                    'product' => 'data|' . $bt->plan,
                    'amount' => $bt->ramount,
                    'samount' => $request->selling_amount,
                    'server_response' => 'ur fault',
                    'status' => 0,
                    'number' => $request->number,
                    'transactionid' => 'api' . $request->refid,
                    'discountamount' => $bon,
                    'paymentmethod' => 'wallet',
                    'fbalance' => $fbalance,
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
                $url = 'https://easyaccess.com.ng/api/datacard.php';

                $headers = array(
                    'Content-Type: application/json',
                    'AuthorizationToken: fed2524ba6cae4b443f65f60a30a8731'
                );

                $data = array(
                    "network" =>01,
                    "no_of_pins" => 1,
                    "dataplan" => 165,
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
                        'token'=>$data['pin'],
                    ]);
                    $name = $bt->plan;
                    $am = "$bt->plan  was successful| Pin: ".$data['pin'];
                    $ph = $request->number;


                    $admin="info@sammighty.com.ng";
                    Mail::to($admin)->send(new Emailtrans($bo));

                    return response()->json([
                        'message' => $am, 'pin'=>$data['pin'],  'success' => $success,
                        'user' => $user
                    ], 200);
                }else {
                    $success = 0;
                    $zo = $user->wallet + $bt->ramount;
                    $user->wallet = $zo;
                    $user->save();
                    $update=bill_payment::where('id', $bo->id)->update([
                        'server_response'=>$response,
                    ]);
                    $name = $bt->plan;
                    $am = "NGN $request->amount Was Refunded To Your Wallet";
                    $ph = ", Transaction fail";
                    return response()->json([
                        'success' => 0,
                        'message' => $am.' ' .$ph,
                    ]);
                }
            }
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


    public function listtv(Request $request)
    {


        $auth = env('GIFTBILLS');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://giftbills.com/api/v1/tv-packages/'.$request->provider,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$auth,
                'MerchantId: '.env('GIFTBILLS_MID'),
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

        $data1 = json_decode($response, true);
        $data=$data1['data'];

//return $success;
        foreach ($data as $plan){
            $success =$request->provider;
            $planid = $plan["id"];
            $price= $plan['amount'];
            $catid=$plan['id'];
            $validity =$plan['name'];
            $code=$plan['id'];
            $insert= Giftbills::create([
                'plan_id' =>$planid,
                'network' =>$success,
                'plan' =>$validity,
                'code' =>$code,
                'amount'=>$price,
                'tamount'=>$price,
                'ramount'=>$price,
                'cat_id'=>$planid,
            ]);
        }

        return $data1;

//    return view('pam', compact('product'));


    }

}
