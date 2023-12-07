<?php


namespace App\Http\Controllers;


use App\Models\Bonus;
use App\Models\User;
use App\Models\Withdraw;
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

        $url = 'https://app.paylony.com/api/v1/account_name';

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

        $request->validate([
            'amount'=>'required',
            'number'=>'required',
            'id'=>'required',
            'narration'=>'required',
            'name'=>'required',
            'efid'=>'required',
        ]);

        $user = User::find($request->user()->id);

        if ($user->wallet < $request->amount) {
            $mg = "Insufficient Balance in your wallet";

            return response()->json($mg, Response::HTTP_BAD_REQUEST);


        }
        if ($request->amount < 0) {

            $mg = "error transaction";
            return response()->json($mg, Response::HTTP_BAD_REQUEST);

        }
        if ($request->amount < 1000) {

            $mg = "amount must be more than or 1000 above";
            return response()->json($mg, Response::HTTP_BAD_REQUEST);

        }
        $bo = Withdraw::where('refid',$request->refid)->first();
        if ($bo){
            $mg = "duplicate transaction";
            return response()->json([
                'message' => $mg, 'user'=>$user
            ], 200);
        }else{


            $tamount=$user->wallet-$request->amount;
            $ramount=$tamount-20;
            $user->wallet=$ramount;
            $user->save();


            $create=Withdraw::create([
                'username'=>$user->username,
                'amount'=>$request->amount,
                'plan'=>$request->id,
                'bank'=>$request->bank,
                'account_no'=>$request->number,
                'name'=>$request->name,
                'status'=>1,
            ]);
            $paload= array(
                "account_number"=>$request->number,
                "amount"=>$request->amount,
                "bank_code"=>$request->id,
                "narration"=>$request->narration,
                "reference"=>$request->refid,
                "sender_name"=>$request->name,
            );

            $hash=hash_hmac('SHA512', $paload, trim(env('ENCRYPTION_KEY')));
            $url = 'https://api.paylony.com/api/v1/bank_transfer';

            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . env('PAYLONY'),
                'Signature:'.$hash
            );

            $data = array(
                "account_number"=>$request->number,
                "amount"=>$request->amount,
                "bank_code"=>$request->id,
                "narration"=>$request->narration,
                "reference"=>$request->refid,
                "sender_name"=>$request->name,
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
            return response()->json([
                'status' => 'success',
                'message' => $data,
            ]);

        }

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
