<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\VirtualAccounts;

class FetchVirtualAccountController
{

    function getallmyaccount($request)
    {
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        $virtual=VirtualAccounts::where('username', $user->username)->all();

        return response()->json(
            $virtual
            , 200);

    }
}
