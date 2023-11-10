<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BusniessController
{

    function updateprofile(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'business'=>'required',
            'email'=>'required',
            'prefix'=>'required',
        ]);

        $user=User::where('username', Auth::user()->username)->first();

        $user->account_prefix=$request['prefix'];
        $user->name=$request['name'];
        $user->email=$request['email'];
        $user->save();

        if (Auth::user()->apikey == null){
            $randomString = Str::random(20); // Change 20 to your desired length
            $secretKey = 'sk-' . $randomString;
            $user->apikey=$secretKey;
            $user->save();
        }
        return response()->json([
            'status' => 1,
            'message' => "Account Updated",
        ]);

    }
    function updatebusiness(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'cemail'=>'required',
            'phone'=>'required',
        ]);

        $business=Business::where('username', Auth::user()->username)->fist();

        $business->email=$request['email'];
        $business->cemail=$request['cemail'];
        $business->phone=$request['phone'];
        $business->save();

        return response()->json([
            'status' => 1,
            'message' => "Business profile update Successfully",
        ]);
    }
    function apicredential()
    {
        $business=Business::where('username', Auth::user()->username)->first();
        return view('credentials', compact('business'));
    }
    function updatewebhook(Request $request)
    {
        $request->validate([
            'webhook'=>['required', 'url'],
        ]);

        $user=User::where('username', Auth::user()->username)->first();
        $user->webhook=$request->webhook;
        $user->save();

        return response()->json([
            'status' => 1,
            'message' => "Webhook Update Successfully",
        ]);
    }

}
