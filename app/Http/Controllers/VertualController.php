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
            if ($user->account_prefix== null ){
                $msg="Kindly update your Business Profile before clicking generate virtual account";
                return response()->json([
                    'status' => 'success',
                    'message' => $msg,
                ]);
            }

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
            CURLOPT_POSTFIELDS => '{
    "firstname":"'.$user['account_prefix'].'",
    "lastname":"'.$user['name'].'",
    "address":"ikeja lagos",
    "gender":"Male",
    "email":"'.$user['email'].'",
    "phone":"'.$business['phone'].'",
    "dob":"1995-03-13",
     "provider":"netbank"
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . env('PAYLONY')
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
                    'provider' => $bank,
                    'refid' => $ref,
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
