<?php

namespace App\Http\Controllers\api;

use App\Models\bill_payment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\data;
use App\Models\Deposit;



class ResellerdetailsController
{
//    wallet balance of reseller
    public function details(Request $request)
    {
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        if ($user) {

            $deposite = Deposit::where('username', $user->username)->get();
            $totaldeposite = 0;
            foreach ($deposite as $depo){
                $totaldeposite += $depo->amount;

            }
            $bil2 = bill_payment::where('username', $user->username)->get();
            $bill = 0;
            foreach ($bil2 as $bill1){
                $bill += $bill1->amount;

            }
            return response()->json([
                'success' => 1,
                'message' => 'Data Fetch Successfully',
                'user' => $user,
                ], 200);
        }
    }

//    fundhistory of reseller
    function fundhistory(Request $request)
    {
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        $data = deposit::where('username', $user->username)->get();

        return response()->json([
            'success'=>1,
            'message' => "Deposit fetch successfully", 'data' => $data
        ], 200);
    }

//    puchasehistory of reseller
    function purchasehistory(Request $request)
    {
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        $data = bill_payment::where('username', $user->username)->get();

        return response()->json([
            'success'=>1,
            'message' => "Purchase fetch successfully", 'data' => $data
        ], 200);
    }
}
