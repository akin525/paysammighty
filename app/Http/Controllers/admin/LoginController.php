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

        $todaypurchase=bill_payment::where(['created_at', 'LIKE', '%'.$today.'%'])->sum('amount');
        $todaypurchasenumber=bill_payment::where(['created_at', 'LIKE', '%'.$today.'%'])->count();
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


        return view('admin/dashboard', compact('todaycollection', 'todaycollectionnumber',
        'todaypurchase', 'todaypurchasenumber', 'todaydepositcharges', 'allcollection', 'allpurchase', 'allcharges',
        'newuser', 'alluser', 'alluserwallet', 'alluserbonus', 'paylonybalance', 'paylonypending'
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
