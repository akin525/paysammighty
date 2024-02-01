<?php

namespace App\Http\Controllers;

use App\Charts\UserChart;
use App\Console\encription;
use App\Mail\login;
use App\Models\Advert;
use App\Models\airtimecon;
use App\Models\big;
use App\Models\bill_payment;
use App\Models\charge;
use App\Models\charp;
use App\Mail\Emailpass;
use App\Models\easy;
use App\Models\Giveaway;
use App\Models\Messages;
use App\Models\refer;
use App\Models\safe_lock;
use App\Models\server;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\wallet;
use App\Models\bo;
use App\Models\data;
use App\Models\deposit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use mysql_xdevapi\Exception;
use RealRashid\SweetAlert\Facades\Alert;


class AuthController
{
    public function landing()
    {
        $mtn=data::where('network', 'mtn-data')->limit(7)->get();
        $glo=data::where('network', 'glo-data')->limit(7)->get();
        $eti=data::where('network', 'etisalat-data')->limit(7)->get();
        $airtel=data::where('network', 'airtel-data')->limit(7)->get();
//        Alert::image('Latest News', $me->message,'https://renomobilemoney.com/images/bn.jpeg','200','200', 'Image Alt');

//Alert::info('Renomobilemoney', 'Data Refill | Airtime | Cable TV | Electricity Subscription');
        return view("home", compact("mtn", "glo", "eti", "airtel"));
    }

    public function select(Request  $request)
    {
        $serve = server::where('status', '1')->first();
//
        if (isset($serve)) {
            $user = User::find($request->user()->id);


            return view('bills.data', compact('user', 'serve'));
        } else {
//            Alert::info('Server', 'Out of service, come back later');
            return redirect('dashboard')->with('error', 'Out of service, come back later');
        }
    }
    public function select1(Request  $request)
    {
        $serve = server::where('status', '1')->first();
//        if (Auth::user()->bvn==NULL){
//            Alert::warning('Update', 'Please Kindly Update your profile including your bvn for account two & to continue');
//            return redirect()->intended('myaccount')
//                ->with('info', 'Please Kindly Update your profile including your bvn for account two');
//        }
        if (isset($serve)) {
            $user = User::find($request->user()->id);
            $ads=Advert::where('status', 1)->inRandomOrder()->orderBy('id', 'desc')->first();


            return view('select1', compact('user', 'serve', 'ads'));
        }else {
            Alert::info('Server', 'Out of service, come back later');
            return redirect('dashboard');
        }
    }
    public function buydata(Request  $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $serve = server::where('status', '1')->first();

        if ($serve->name == 'mcd') {
            $user = User::find($request->user()->id);
            $data = data::where(['status' => 1])->where('network', $request->id)->get();


            return view('buydata', compact('user', 'data'));
        } elseif ($serve->name == 'honorworld') {
            $user = User::find($request->user()->id);
            $data= big::where('status', '1')->where('network', $request->id)->get();
//return $data;
            return view('buydata', compact('user', 'data'));

        }elseif ($serve->name == 'easyaccess') {
            $user = User::find($request->user()->id);
            $data= easy::where('status', '1')->where('network', $request->id)->get();
//return $data;
            return view('buydata', compact('user', 'data'));

        }
       }
    public function redata(Request  $request, $selectedValue)
    {

        $daterserver = new DataserverController();
        $serve = server::where('status', '1')->first();
//return $request->id;
        if ($serve->name == 'mcd') {
            $user = User::find($request->user()->id);
            $data = data::where(['status' => 1])->where('network', $selectedValue)->get();

            return response()->json($data);

        } elseif ($serve->name == 'honorworld') {
            $user = User::find($request->user()->id);
            $data= big::where('status', '1')->where('network',$selectedValue)->get();
//return $data;
            return response()->json($data);

        }elseif ($serve->name == 'easyaccess') {
            $user = User::find($request->user()->id);
            $data= easy::where('status', '1')->where('network', $selectedValue)->get();
//return $data;
            return response()->json($data);

        }
       }
    public function pre(Request $request)


    {
        $request->validate([
            'id' => 'required',
        ]);
        if(Auth::check()){
            $user = User::find($request->user()->id);
            $data = data::where('id',$request->id )->get();

            return view('pre', compact('user', 'data'));
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }
    public function airtime(Request  $request)
    {
        $con=DB::table('airtimecons')->where('status', '=', '1')->first();
        if (isset($con)) {
            $se = $con->server;
        }else{
            $se=0;
        }
        if ($se == 'MCD') {
            $user = User::find($request->user()->id);
            $data = data::where('plan_id', "airtime")->get();
//            $wallet = wallet::where('username', $user->username)->first();
            $ads=Advert::where('status', 1)->inRandomOrder()->orderBy('id', 'desc')->first();

            return view('airtime', compact('user', 'data', 'ads'));
        } elseif ($se == 'Honor'){
            return view('airtime1');

        }else {
            Alert::info('Server', 'Out of service, come back later');
            return redirect('dashboard');
        }
    }

    public function invoice(Request  $request)
    {
        if(Auth::check()){
            $user = User::find($request->user()->id);
            $bill = bill_payment::where('username', $user->username)->get();


            return view('invoice', compact('user', 'bill'));
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }
    public function charges(Request  $request)
    {
        if(Auth::check()){
            $user = User::find($request->user()->id);
            $bill = charge::where('username', $request->user()->username)->get();


            return view('charges', compact('user', 'bill'));
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }
}
