<?php

namespace App\Http\Controllers\admin;

use App\Models\bill_payment;
use App\Models\charp;
use App\Models\Deposit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController
{

    function adminlogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->where('role', 'admin')
            ->first();

        if (!isset($user) || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['admin' => 'Invalid credentials or you have not been assigned as an admin.']);
        }

        Auth::login($user);

        return redirect()->intended('admin/dashboard')->withSuccess('Signed in');
    }
    public function index()
    {
        return view('admin.auth.login');

    }

    function admindashboard(){
        $today = Carbon::now()->format('Y-m-d');
        $todaycollection=Deposit::where([['created_at', 'LIKE', '%' . $today . '%']])->sum('amount');
        $todaycollectionnumber=Deposit::where([['created_at', 'LIKE', '%' . $today . '%']])->count();
        $allcollection=Deposit::sum('amount');
        $date = Carbon::now()->format("Y-m");
        $thisweek= Deposit::where([['created_at', 'LIKE', $date . '%']])->sum('amount');


        $url1 = 'https://reseller.mcd.5starcompany.com.ng/api/v1/my-balance';

        $headers1 = array(
            'Content-Type: application/json',
            'Authorization: Bearer U0z27c35Q2ABESJDp3GWO2DbKNBCp8hQTD9zS8TXC2ZSaN8VPHZFTqkntLwbtQVNJRWLabCJpqOUwCq7JVDtcAFHWV3NVNFEDzSaPBUE0YXiG9VdLdqezLmlXOlOgT3nBLEV4OZRDXpXs82Zn5Ofti',
        );

        $options = array(
            'http' => array(
                'header' => implode("\r\n", $headers1),
                'method' => 'GET',
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url1, false, $context);

        $data = json_decode($response, true);
        $mcd = $data["data"]["wallet"];
        $mcdc=$data["data"]["commission"];

        $todaypurchase=bill_payment::where([['created_at', 'LIKE', '%'.$today.'%']])->sum('amount');
        $todaypurchasenumber=bill_payment::where([['created_at', 'LIKE', '%'.$today.'%']])->count();
        $allpurchase=bill_payment::sum('amount');

        $todaydepositcharges=charp::where([['created_at', 'LIKE', '%' . $today . '%']])->sum('amount');
        $allcharges=charp::sum('amount');

        $newuser=User::where([['created_at', 'LIKE', '%' . $today . '%']])->count();
        $alluser=User::count();

        $alluserwallet=User::sum('wallet');
        $alluserbonus=User::sum('bonus');

        $url = 'https://api.paylony.com/api/v1/wallet_balance';

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
        $paylonybalance=$data['data']['balance'];
        $paylonypending=$data['data']['pending'];


        $url2 = 'https://easyaccess.com.ng/api/wallet_balance.php';

        $headers1 = array(
            'Content-Type: application/json',
            "AuthorizationToken:  fed2524ba6cae4b443f65f60a30a8731", //replace this with your authorization_token

        );
        $options = array(
            'http' => array(
                'header' => implode("\r\n", $headers1),
                'method' => 'GET',
            ),
        );

        $context2 = stream_context_create($options);
        $response2= file_get_contents($url2, false, $context2);

        $data2 = json_decode($response2, true);
        if ($data2['success']=='true'){
            $easy=$data2['balance'];
        }


        $userId ='CK100308875';
        $apiKey ='961MT1M6C4DD542FL648614W41Q2OLDERYYOQMK6M66XZC2DPPP6671064N8TB94';
        $url3 = "https://www.nellobytesystems.com/APIWalletBalanceV1.asp?UserID=$userId&APIKey=$apiKey";

        $options = array(
            'http' => array(
                'method' => 'GET',
            ),
        );

        $context = stream_context_create($options);
        $res=file_get_contents($url3, false, $context);
        $data3 = json_decode($res, true);
//        return $res;
        if (isset($data3['balance'])) {
            $club = $data3['balance'];
        }else{
            $club=0.00;
        }

        return view('admin/dashboard', compact('todaycollection', 'todaycollectionnumber',
        'todaypurchase', 'todaypurchasenumber', 'todaydepositcharges', 'allcollection', 'allpurchase', 'allcharges',
        'newuser', 'alluser', 'club', 'alluserwallet', 'mcdc',  'alluserbonus', 'paylonybalance', 'easy',  'paylonypending', 'thisweek', 'mcd'
        ));

    }
    public function getTransactions()
    {
        $transactions = Deposit::selectRaw('DATE(date) as date, SUM(amount) as total_amount')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $dates = $transactions->pluck('date')->toArray();
        $amounts = $transactions->pluck('total_amount')->toArray();

        return response()->json([
            'dates' => $dates,
            'amounts' => $amounts,
        ]);
    }
    public function getTransactions1()
    {
        $transactions = bill_payment::selectRaw('DATE(timestamp) as date, SUM(amount) as total_amount')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $dates = $transactions->pluck('date')->toArray();
        $amounts = $transactions->pluck('total_amount')->toArray();

        return response()->json([
            'dates' => $dates,
            'amounts' => $amounts,
        ]);
    }

}
