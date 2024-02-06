<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\airtimecon;
use App\Models\server;
use Illuminate\Http\Request;

class ServerController extends Controller
{

    public function server()
    {
        $server=server::get();

        return view('admin/server', compact('server'));
    }

    public function up($request)
    {
        $server=server::where('id', $request)->first();
        if ($server->status==1)
        {
            $u="0";
        }else{
            $u="1";
        }

        $server->status=$u;
        $server->save();
        return redirect(url('admin/server'))
            ->with('status',' Server change successfully');

    }


}
