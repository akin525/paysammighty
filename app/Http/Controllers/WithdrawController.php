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

        $user=User::where('username', Auth::user()->username)->first();
        if ($user->bvn == null){
            $msg="Kindly Update your BVN On Sammighty";
            return redirect('dashboard')->with('error', $msg);
        }

        if ($user->withdraw == "0"){
            $msg="Transfer option not enable kindly contact the admin";
            return redirect('dashboard')->with('error', $msg);
        }else {
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

            $bank = $data["data"]["banks"];
            return view('withdraw', compact('bank'));
        }
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

        $request->validate([
            'amount'=>'required',
            'number'=>'required',
            'id'=>'required',
            'narration'=>'required',
            'name'=>'required',
            'refid'=>'required',
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
        if ($request->amount < 100) {

            $mg = "amount must be more than or 100 above";
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



            $payloadData = array(
                "account_name"=>$request->name,
                "account_number" => $request->number,
                "amount" => $request->amount,
                "bank_code" => $request->id,
                "narration" => $request->narration,
                "reference" => $request->refid,
                "sender_name" => $request->name,
            );

            ksort($payloadData);

// Convert the sorted payload back to a JSON string
            $payload = json_encode($payloadData);

// Ensure the key is trimmed properly and matches the API's expectations
            $trimmedKey = trim(env('ENCRYPTION_KEY'));

// Calculate the hash using HMAC-512
            $hash = hash_hmac('SHA512', $payload, $trimmedKey);

            $url = 'https://api.paylony.com/api/v1/bank_transfer';

            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . env('PAYLONY'),
                'Signature:'.$hash
            );

            $data = array(
                "account_name"=>$request->name,
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
            $create=Withdraw::create([
                'username'=>$user->username,
                'amount'=>$request->amount,
                'plan'=>$request->id,
                'refid'=>$request->refid,
                'bank'=>$request->bank,
                'account_no'=>$request->number,
                'name'=>$request->name,
                'status'=>1,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => $data['message'],
                "pay"=> $payload ,
                "has"=>$hash,
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
