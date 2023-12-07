<?php


namespace App\Http\Controllers;


use App\Models\Bonus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class WithdrawController
{

    function allbank()
    {
        $url = 'https://api.paylony.com/api/v1/bank_list';

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . env('PAYLONY')
        );


        $options = array(
            'http' => array(
                'header' => implode("\r\n", $headers),
                'method' => 'GET',
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        $data = json_decode($response, true);

        $bank=$data["data"]["banks"];
        return view('withdraw', compact('bank'));
    }

    function verifyaccount($valuea, $valueb)
    {
        $url = 'https://api.paylony.com/api/v1/account_name';

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . env('PAYLONY')
        );

        $data = array(
            "bank_code" =>$valueb,
            "account_number" => $valuea,
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


        if ($data["success"]=="true"){
            $name=$data['data'];
        }else{
            $name=$data["message"];
        }

        return response()->json($name);

    }

    function withdraw(Request $request)
    {

    }

    function withdrawtowallet()
        {

            return view('walletto');
        }

        function confirmto(Request $request)
        {
            $request->validate([
                'amount' => ['required', 'numeric', 'min:4'],
            ]);
            $user = User::find($request->user()->id);

            if ($user->bonus < $request->amount) {
                $mg = "Insufficient Balance in your bonus";

                return response()->json($mg, Response::HTTP_BAD_REQUEST);


            }
            if ($request->amount < 0) {

                $mg = "error transaction";
                return response()->json($mg, Response::HTTP_BAD_REQUEST);



            }


            $bonus=Auth::user()->bonus;
            $wallet=Auth::user()->wallet;

            $ubonus=$bonus-$request->amount;
            $to=$bonus+$wallet;
            $create=Bonus::create([
                'username'=>$user->username,
                'amount'=>$request->amount,
                'tamount'=>$to,
            ]);
            $user->wallet=$to;
            $user->bonus=$ubonus;
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => "Your Bonus has been added to your wallet successfully",
            ]);

        }
}
