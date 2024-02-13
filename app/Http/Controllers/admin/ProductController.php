<?php

namespace app\Http\Controllers\admin;

use App\Models\airtimecon;
use App\Models\big;
use App\Models\data;
use App\Models\easy;
use App\Models\Mcd;
use App\Models\McdServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController
{
public function index()
{
    $product=easy::all();

    return view('admin/product', compact('product'));
}
public function index1()
{
    $product=Mcd::all();

    return view('admin/product1', compact('product'));
}

public function on(Request $request)
{
    $product = easy::where('id', $request->id)->first();

    if ($product->status == "1") {
        $give = "0";
    } else {
        $give = "1";
    }
    $product->status = $give;
    $product->save();
    $msg= 'Product update successfully';

    return redirect('admin/product')->with('status', $msg);

}
public function on1(Request $request)
{
    $product = Mcd::where('id', $request->id)->first();

    if ($product->status == "1") {
        $give = "0";
    } else {
        $give = "1";
    }
    $product->status = $give;
    $product->save();
    $msg= 'Product update successfully';

    return redirect('admin/product1')->with('status', $msg);

}
public function in(Request $request)
{

    $pro=data::where('id', $request->id)->first();

return view('admin/editproduct', compact('pro'));
}

public function edit(Request $request)
{
    $request->validate([
        'id' => 'required',
        'amount' => 'required',
        'tamount' => 'required',
        'ramount' => 'required',
        'name' => 'required',
    ]);
    $pro=easy::where('id', $request->id)->first();
    $pro->plan=$request->name;
    $pro->amount=$request->amount;
    $pro->tamount=$request->tamount;
    $pro->ramount=$request->ramount;
    $pro->save();
    return response()->json([
        'status'=>'success',
        'message'=>'Product update successfully',
    ]);
}
public function edit1(Request $request)
{
    $request->validate([
        'id' => 'required',
        'amount' => 'required',
        'tamount' => 'required',
        'ramount' => 'required',
        'name' => 'required',
    ]);
    $pro=Mcd::where('id', $request->id)->first();
    $pro->plan=$request->name;
    $pro->amount=$request->amount;
    $pro->tamount=$request->tamount;
    $pro->ramount=$request->ramount;
    $pro->save();
    return response()->json([
        'status'=>'success',
        'message'=>'Product update successfully',
    ]);
}


public function air()
{
    $air=DB::table('airtimecons')->get();

    return view('admin/air', compact("air"));
}

public function pair(Request $request)
{
    $air = airtimecon::where('id', $request->id)->first();
    if ($air->status == 1){
        $na= '0';
    }elseif ($air->status == 0){
        $na='1';
    }

    $air->status=$na;
    $air->save();

    return redirect('admin/air')->with('status', 'Server update successfully');

}

function mcdserver()
{
    $server=McdServer::all();
    return view('admin/mcdserver', compact('server'));

}
function createservermcd(Request $request)
{
    $request->validate([
        'category'=>'required',
        'server'=>'required',
        'name'=>'required',
    ]);


    $insert=McdServer::create([
        'name'=>$request->name,
        'category'=>$request->category,
        'server'=>$request->server,
        ]);
    $msg="Sever created Successful";
    return response()->json([
        'status'=>'success',
        'message'=>$msg,
        ]);

}
function changeservermcd(Request $request)
{
    $request->validate([
        'id'=>'required',
        'server'=>'required',
    ]);
    $insert=McdServer::where('id', $request->id)->first();

    $insert->server=$request->server;
    $insert->save();

    $msg="Sever change to ".$request->server." Successful";
    return response()->json([
        'status'=>'success',
        'message'=>$msg,
        ]);

}


}
