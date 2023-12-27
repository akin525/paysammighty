<?php


namespace App\Http\Controllers\admin;


use App\Models\Messages;
use Illuminate\Http\Request;

class MessageController
{
 function messageindexload()
 {
     $message=Messages::where('status', 1)->first();
     return view('admin/message', compact('message'));
 }

 function updatemessage(Request $request)
 {
     $request->validate([
         'message'=>'required',

     ]);

     $message=Messages::where('status', 1)->first();
     $message->message=$request->message;
     $message->save();

     return response()->json([
         'success'=>0,
         'message' => 'Notification Updated',
     ]);
 }
}
