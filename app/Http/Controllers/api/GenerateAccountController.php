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
            'refid'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $this->error_processor($validator)
            ], 403);
        }
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
//        $virtual=VirtualAccounts::where('refid', $request->refid)->first();



            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://app.paylony.com/api/v1/create_account',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
   "firstname": "' . $request['firstname'] . '",
        "lastname": "' . $request['lastname'] . '",
        "address": "' . $request['address'] . '",
        "gender": "' . $request['gender'] . '",
        "email": "' . $request['email'] . '",
        "phone": "' . $request['phone'] . '",
        "dob": "' . $request['dob'] . '",
        "provider": "providus"
}',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . env('PAYLONY')
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
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
    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['success'=> 0, 'code' => $index, 'message' => $error[0]]);
        }
        return $err_keeper;
    }
}
