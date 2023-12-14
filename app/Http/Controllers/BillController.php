<?php
namespace App\Http\Controllers;
use App\Console\encription;
use App\Mail\Emailfund;
use App\Mail\Emailtrans;
use App\Models\big;
use App\Models\bill_payment;
use App\Models\bo;
use App\Models\data;
use App\Models\deposit;
use App\Models\easy;
use App\Models\profit;
use App\Models\profit1;
use App\Models\server;
use App\Models\setting;
use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{


    public function bill(Request $request)
    {
        $request->validate([
            'productid' => 'required',
            'number'=>['required', 'numeric',  'digits:11'],
            'refid' => 'required',
        ]);

        if (Auth::check()) {
            $user = User::find($request->user()->id);
            $serve = server::where('status', '1')->first();
            if ($serve->name == 'honorworld') {
                $product = big::where('id', $request->productid)->first();
            } elseif ($serve->name == 'mcd') {
                $product = data::where('id', $request->productid)->first();
            }elseif ($serve->name == 'easyaccess') {
                $product = easy::where('id', $request->productid)->first();
            }

            if ($user->apikey == '') {
                $amount = $product->tamount;
            } elseif ($user != '') {
                $amount = $product->ramount;
            }

            if ($user->wallet < $amount) {
                $mg = "You Cant Make Purchase Above" . "NGN" . $amount . " from your wallet. Your wallet balance is NGN $user->wallet. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";
                return response()->json( $mg, Response::HTTP_BAD_REQUEST);

            }
            if ($request->amount < 0) {

                $mg = "error transaction";
                return response()->json( $mg, Response::HTTP_BAD_REQUEST);

            }
            $bo = bill_payment::where('transactionid', $request->refid)->first();
            if (isset($bo)) {
                $mg = "duplicate transaction";
                return response()->json( $mg, Response::HTTP_CONFLICT);

            } else {
                $user = User::find($request->user()->id);

                $fbalance=$user->wallet;

                $gt = $user->wallet - $amount;


                $user->wallet= $gt;
                $user->save();
                $bo = bill_payment::create([
                    'username' => $user->username,
                    'product' => 'data|' . $product->plan,
                    'amount' => $amount,
                    'samount' => $amount,
                    'server_response' => 'ur fault',
                    'status' => 0,
                    'number' => $request->number,
                    'transactionid' => $request->refid,
                    'discountamount'=>0,
                    'paymentmethod'=> 'wallet',
                    'fbalance'=>$fbalance,
                    'balance'=>$gt,
                ]);

                $object = json_decode($product);
                $object->number = $request->number;
                $object->refid = $request->refid;
                $json = json_encode($object);

                $daterserver = new DataserverController();
                $mcd = server::where('status', "1")->first();

                if ($mcd->name == "honorworld") {
                    $response = $daterserver->honourwordbill($object);
//return $response;
                    $data = json_decode($response, true);
                    $success = "";
                    if ($data['code'] == '200') {
                        $success = 1;
                        $ms = $data['message'];

//                    echo $success;

                        $po = $amount - $product->amount;



                        $profit = profit::create([
                            'username' => $user->username,
                            'plan' => $product->network . '|' . $product->plan,
                            'amount' => $po,
                        ]);

                        $bo->server_response=$response;
                        $bo->status=1;
                        $bo->save();

//                        $name = $product->plan;
                        $am = "$product->plan  was successful delivered to";
                        $ph = $request->number;

                        $admin="info@sammighty.com.ng";
                        Mail::to($admin)->send(new Emailtrans($bo));

                        return response()->json([
                            'status' => 'success',
                            'message' => $am.' ' .$ph,
//                            'data' => $responseData // If you want to include additional data
                        ]);

                    } elseif ($data['code'] == '300') {
                        $success = 0;
                        $zo = $user->wallet + $request->amount;
                        $user->wallet= $zo;
                        $user->save();

                        $name = $product->plan;
                        $am = "NGN $request->amount Was Refunded To Your Wallet";
                        $ph = ", Transaction fail";

                        return response()->json([
                            'status' => 'fail',
                            'message' => $am.' ' .$ph,
//                            'data' => $responseData // If you want to include additional data
                        ]);

                    }
                }
                else if ($mcd->name == "mcd") {
                    $response = $daterserver->mcdbill($object);

                    $data = json_decode($response, true);

                    if (isset($data['success'])) {
                        $dis=$data['discountAmount'];
//                    echo $success;
                        $success = "1";
                        $po = $amount - $product->amount;



                        $profit = profit::create([
                            'username' => $user->username,
                            'plan' => $product->network . '|' . $product->plan,
                            'amount' => $po,
                        ]);
                        $update=bill_payment::where('id', $bo->id)->update([
                            'server_response'=>$response,
                            'status'=>1,
                        ]);
                        $name = $product->plan;
                        $am = "$product->plan  was successful delivered to";
                        $ph = $request->number;



                        return response()->json([
                            'status' => 'success',
                            'message' => $am.' ' .$ph,
//                            'data' => $responseData // If you want to include additional data
                        ]);

                    }elseif (!isset($data['success'])) {
                        $success = 0;
//                        $zo = $wallet->balance + $request->amount;
//                        $wallet->balance = $zo;
//                        $wallet->save();
                        $update=bill_payment::where('id', $bo->id)->update([
                            'server_response'=>$response,
                        ]);
                        $name = $product->plan;
                        $am = "NGN $request->amount Was Refunded To Your Wallet";
                        $ph = ", Transaction fail";
                        return response()->json([
                            'status' => 'fail',
                            'message' =>$response,
//                            'data' => $responseData // If you want to include additional data
                        ]);

                    }

                }elseif ($mcd->name == "easyaccess") {
                    $response = $daterserver->easyaccess($object);

                    $data = json_decode($response, true);
//                    return $response;
                    $success = "";
                    if ($data['success'] == 'true') {
                        $success = 1;
                        $ms = $data['message'];

//                    echo $success;

                        $po = $amount - $product->amount;


                        $profit = profit::create([
                            'username' => $user->username,
                            'plan' => $product->network . '|' . $product->plan,
                            'amount' => $po,
                        ]);

                        $update=bill_payment::where('id', $bo->id)->update([
                            'server_response'=>$response,
                            'status'=>1,
                        ]);
                        $name = $product->plan;
                        $am = "$product->plan  was successful delivered to";
                        $ph = $request->number;
                        return response()->json([
                            'status' => 'success',
                            'message' => $am.' ' .$ph,
//                            'data' => $responseData // If you want to include additional data
                        ]);

                    } elseif ($data['success'] == 'false') {


                        $name = $product->plan;
                        $am = "NGN $request->amount Was Refunded To Your Wallet";
                        $ph = ", Transaction fail";
                        return response()->json([
                            'status' => 'fail',
                            'message' =>$response,
                        ]);
                    }
                }


//return $response;
            }
        }
    }
    public  function allbils()
    {
        $bill=bill_payment::where('username', Auth::user()->username)->get();

            return view('bills.trans', compact('bill'));
    }
}




