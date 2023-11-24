<?php

namespace App\Http\Controllers;
use App\Mail\Emailcharges;
use App\Mail\Emailfund;
use App\Models\bo;
use App\Models\Business;
use App\Models\charp;
use App\Models\data;
use App\Models\deposit;
use App\Models\setting;
use App\Models\VirtualAccounts;
use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class VertualController
{
    public function vertual()
    {
            $user = User::where('username', Auth::user()->username)->first();
            $business=Business::where('username', Auth::user()->username)->first();
//            if ($user->account_prefix== null ){
//                $msg="Kindly update your Business Profile before clicking generate virtual account";
//                return response()->json([
//                    'status' => 'success',
//                    'message' => $msg,
//                ]);
//            }
            $input=$user;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.paylony.com/api/v1/create_account',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
    "firstname": "'.$input['account_prefix'].'",
        "lastname": "'.$input['name'].'",
        "address": "lagos nigeria",
        "gender": "Male",
        "email": "'.$input['email'].'",
        "phone": "'.$business['phone'].'",
        "dob": "1995-03-13",
        "provider": "gtb"
}',
                CURLOPT_HTTPHEADER => array(
                    '1Content-Type: application/json',
                    'Authorization: Bearer '.env('PAYLONY')
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $data = json_decode($response, true);
            if ($data['success']=="true") {
                $account = $data["data"]["account_name"];
                $number = $data["data"]["account_number"];
                $bank = $data["data"]["provider"];
                $ref= $data['data']['reference'];

                $business->account_number = $number;
                $business->account_name = $account;
                $business->bank=$bank;
                $business->save();


                $create = VirtualAccounts::create([
                    'username' => $user->username,
                    'account_number' => $number,
                    'customer' => $account,
                    'bank' => $bank,
                    'ref' => $ref,
                ]);
                return response()->json([
                    'status' => '1',
                    'message' => "Account Generated Successfully",
                ]);
            }elseif ($data['success']==0){

                return response()->json([
                    'status' => '0',
                    'message' => $response,
                ]);
            }

        }

}
