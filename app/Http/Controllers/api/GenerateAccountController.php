<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\VirtualAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenerateAccountController
{

    function generateaccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'dob' => 'required',
            'phone' => 'required',
//            'refid'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $this->error_processor($validator)
            ], 403);
        }
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
//        $virtual=VirtualAccounts::where('refid', $request->refid)->first();



        $url = 'https://api.paylony.com/api/v1/create_account';

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . env('PAYLONY')
        );

        $data = array(
            "firstname" =>$request['firstname'],
            "lastname" => $request['lastname'],
            "address" => $request['address'],
            "gender" => $request['gender'],
            "email" => $request['email'],
            "phone" => $request['phone'],
            "dob" => $request['dob'],
            "provider" => "safeheaven"
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
            if ($data['success'] == "true") {
                $account = $data["data"]["account_name"];
                $number = $data["data"]["account_number"];
                $bank = $data["data"]["provider"];
                $ref = $data['data']['reference'];

                $virtual=VirtualAccounts::where('refid', $ref)->first();

                if ($virtual) {

                    return response()->json([
                        'message' => "Account already generated",
                        'data' => $data,
                        'success' => 1
                    ], 200);

                }
                $create = VirtualAccounts::create([
                    'username' => $user->username,
                    'account_number' => $number,
                    'customer' => $account,
                    'provider' => $bank,
                    'refid' => $ref,
                ]);
//                $data = ["account_number" => $number, "account_name" => $account,
//                    "bank" => $bank, "reference" => $ref];

                return response()->json([
                    'message' => "Account generated",
                    'data' => $data,
                    'success' => 1
                ], 200);
            }else{
                return response()->json([
                    'message' => "error",
                    'data' => $data,
                    'success' => 0
                ], 200);

            }
        }
    function generateaccountmcd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'uniqueid' => 'required',
            'email' => 'required',
            'webhook' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $this->error_processor($validator)
            ], 403);
        }
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
//        $virtual=VirtualAccounts::where('refid', $request->refid)->first();



        $url = 'https://integration.mcd.5starcompany.com.ng/api/reseller/virtual-account';

        $headers = array(
            'Content-Type: application/json',
            'Authorization: MCDKEY_903sfjfi0ad833mk8537dhc03kbs120r0h9a'

        );

        $data1 = array(
            "account_name"=>$request['name'],
            "business_short_name"=>$user['account_prefix'],
            "email"=>$request['email'],
            "uniqueid"=>$request['uniqueid'],
            "phone"=>$request['phone'],
            "webhook_url"=>$request['webhook']
        );

        $options = array(
            'http' => array(
                'header' => implode("\r\n", $headers),
                'method' => 'POST',
                'content' => json_encode($data1),
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        $data = json_decode($response, true);
            if ($data['success'] == "1") {
                $account = $data["data"]["account_name"];
                $number = $data["data"]["account_number"];
                $bank = $data["data"]["bank_name"];
                $ref = $data['data']['account_reference'];

                $virtual=VirtualAccounts::where('refid', $ref)->first();

                if ($virtual) {

                    return response()->json([
                        'message' => "Account already generated",
                        'data' => $data,
                        'success' => 1
                    ], 200);

                }
                $create = VirtualAccounts::create([
                    'username' => $user->username,
                    'account_number' => $number,
                    'customer' => $account,
                    'provider' => $bank,
                    'refid' => $ref,
                ]);
//                $data = ["account_number" => $number, "account_name" => $account,
//                    "bank" => $bank, "reference" => $ref];

                return response()->json([
                    'message' => "Account generated",
                    'data' => $data,
                    'success' => 1
                ], 200);
            }else{
                return response()->json([
                    'message' => "error",
                    'data' => $data,
                    'success' => 0
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
