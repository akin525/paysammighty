<?php

namespace App\Http\Controllers\api;


use App\Models\Business;
use App\Models\charp;
use App\Models\Deposit;
use App\Models\setting;
use App\Models\User;
use App\Models\VirtualAccounts;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class WehookController
{

    function sendwebhook(Request $request)
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data || !isset($data['reference'], $data['amount'], $data['receiving_account'], $data['sender_narration'])) {
                // Handle invalid JSON or missing keys
                throw new \Exception('Invalid JSON or missing keys.');
            }
            $refid = $data["reference"];
            $amount = $data["amount"];
            $account = $data['receiving_account'];
            $narration = $data["sender_narration"];
            $virtual = VirtualAccounts::where('account_number', $account)->first();
            $user = User::where('username', $virtual->username)->first();
            $pt = $user['wallet'];
            if ($account != $virtual->account_number) {
                // Handle invalid account
                throw new \Exception('Invalid account.');
            } else {
                $depo = Deposit::where('refid', $refid)->first();
                if ($depo) {
                    // Handle duplicate payment refid
                    throw new \Exception('Payment refid already exists.');
                } else {

                    $char = setting::first();
                    $amount1 = $amount - $char->charges;


                    $gt = $amount1 + $pt;
                    $reference = $refid;

//                $deposit['narration']=$narration;
                    $deposit = Deposit::create([
                        'username' => $user->username,
                        'refid' => $refid,
                        'amount' => $amount,
                        'iwallet' => $pt,
                        'fwallet' => $gt,
                    ]);
                    $wt = WalletTransaction::create([
                        'username' => $user->username,
                        'refid' => $refid,
                        'amount' => $amount,
                        'bb' => $pt,
                        'bf' => $gt,
                    ]);
                    $user->wallet = $gt;
                    $user->save();
                    $charp = charp::create([
                        'username' => $user->username,
                        'refid' => $reference,
                        'amount' => $char->charges,
                        'iwallet' => $pt,
                        'fwallet' => $gt,
                    ]);


                    $admin = 'info@sammighty.com.ng';

                    $receiver = $user->email;

                    if ($user->webhook != null) {

                        $resellerURL = $user->webhook;
                        $curl = curl_init();

                        curl_setopt_array($curl, [
                            CURLOPT_URL => $resellerURL,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_SSL_VERIFYHOST => 0,
                            CURLOPT_SSL_VERIFYPEER => 0,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => [
                                "reference" => $refid,
                                "amount" => $amount,
                                "receiving_account" => $account,
                                "sender_narration" => $narration,
                            ],
                        ]);


                        $response = curl_exec($curl);

                        if ($response === false) {
                            // Handle cURL error
                            throw new \Exception(curl_error($curl));
                        }

                        curl_close($curl);
                    }
                }
            }

                    // Your existing code for printing and returning response...
                }catch
                (\Exception $e) {
                    // Handle exceptions, log the error, and return an appropriate response
                    Log::error('Webhook processing error: ' . $e->getMessage());
                    return response()->json(['error' => 'Webhook processing error'], 500);
                }

                }
}
