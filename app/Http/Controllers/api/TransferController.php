<?php


namespace App\Http\Controllers\api;


use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TransferController
{


    function withdraw(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount'=>'required',
            'number'=>'required',
            'id'=>'required',
            'narration'=>'required',
            'name'=>'required',
            'refid'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $this->error_processor($validator)
            ], 403);
        }
        $apikey = $request->header('apikey');

        $user = User::where('apikey',$apikey)->first();

        if ($user->wallet < $request->amount) {
            $mg = "Insufficient Balance in your wallet";

//            return response()->json($mg, Response::HTTP_BAD_REQUEST);

            return response()->json([
                'message' => $mg,
                'user' => $user,
                'success' => 0
            ], 200);

        }
        if ($request->amount < 0) {

            $mg = "error transaction";
//            return response()->json($mg, Response::HTTP_BAD_REQUEST);
            return response()->json([
                'message' => $mg,
                'user' => $user,
                'success' => 0
            ], 200);
        }
        if ($request->amount < 1000) {

            $mg = "amount must be more than or 1000 above";
//            return response()->json($mg, Response::HTTP_BAD_REQUEST);
            return response()->json([
                'message' => $mg,
                'user' => $user,
                'success' => 0
            ], 200);
        }
        $bo = Withdraw::where('refid',$request->refid)->first();
        if ($bo){
            $mg = "duplicate transaction";
            return response()->json([
                'message' => $mg,
                'user' => $user,
                'success' => 0
            ], 200);
        }else{


            $tamount=$user->wallet-$request->amount;
            $ramount=$tamount-20;
            $user->wallet=$ramount;
            $user->save();



            $payloadData = array(
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

            $url = 'https://app.paylony.com/api/v1/bank_transfer';

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

    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['code' => $index, 'message' => $error[0]]);
        }
        return $err_keeper;
    }
}
