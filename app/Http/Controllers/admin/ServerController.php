<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\airtimecon;
use App\Models\server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    function dataindex()
    {
        $server=server::all();
        return view('admin/dataswitch', compact('server'));
    }
    function airtimeindex()
    {
        $server=airtimecon::all();
        return view('admin/airtime', compact('server'));
    }

    function dataswitch(Request $request)
    {

    }

}
