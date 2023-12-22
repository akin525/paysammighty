<?php

namespace App\Http\Controllers\admin;

use App\Models\bill_payment;
use App\Models\Business;
use App\Models\charp;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController
{

    public function index()
    {
        $u=User::get();
        $users=User::paginate(50);
        $reseller=DB::table('users')->where("apikey", "!=", "")->count();
        $t_users = DB::table('users')->count();
        $f_users = DB::table('users')->where("role","=","admin")->count();

        $a_users = DB::table('users')->where("role","=","users")->count();


        return view('admin/allusers', ['users' => $users, 'res'=>$reseller, 't_users'=>$t_users,  'f_users'=>$f_users,'a_users'=>$a_users]);

    }
    public function fin()
    {
        $user=User::get();
        return view('admin/finds', compact('user'));

    }
    public function finduser(Request $request){
        $input = $request->all();
        $user_name=$input['username'];
        $phoneno=$input['phoneno'];
        $status=$input['status'];
        $wallet=$input['wallet'];
        $email=$input['email'];
        $regdate=$input['regdate'];

        // Instantiates a Query object
        $query = User::Where('username', 'LIKE', "%$user_name%")
            ->Where('phone_no', 'LIKE', "%$phoneno%")
            ->Where('email', 'LIKE', "%$email%")
            ->Where('created_at', 'LIKE', "%$regdate%")
            ->limit(500)
            ->get();

        $cquery = User::Where('username', 'LIKE', "%$user_name%")
            ->Where('phone_no', 'LIKE', "%$phoneno%")
            ->Where('email', 'LIKE', "%$email%")
            ->Where('created_at', 'LIKE', "%$regdate%")
            ->count();

        return view('admin/finds', ['users' => $query, 'count'=>$cquery, 'result'=>true]);
    }

    public function profile($username)
    {

        $ap = User::where('username', $username)->first();

        if(!$ap){
            return redirect('admin/finds')->with('error', 'user does not exist');
        }
        $user =User::where('username', $username)->first();
        $bus=Business::where('username', $username)->first();
        $sumtt = Deposit::where('username', $ap->username)->sum('amount');
        $tt = Deposit::where('username', $ap->username)->count();
        $td = Deposit::where('username', $ap->username)->orderBy('id', 'desc')->get();
        $v = DB::table('bill_payments')->where('username', $ap->username)->orderBy('id', 'desc')->get();
        $tat = bill_payment::where('username', $ap->username)->count();
        $sumbo = bill_payment::where('username', $ap->username)->sum('amount');
        $sumch = charp::where('username', $ap->username)->sum('amount');
        $charge = charp::where('username', $ap->username)->paginate(10);
        $cname=$user->name;
        $cphone=$user->phone;
        $cmail=$user->email;
        return view('admin/profile', ['user' => $ap, 'sumtt'=>$sumtt, 'bus'=>$bus, 'charge'=>$charge,  'sumch'=>$sumch, 'sumbo'=>$sumbo, 'tt' => $tt, 'td' => $td, 'cphone'=>$cphone, 'cname'=>$cname, 'cmail'=>$cmail,   'version' => $v,  'tat' =>$tat]);
    }
}
