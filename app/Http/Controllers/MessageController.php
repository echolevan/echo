<?php

namespace App\Http\Controllers;

use App\Events\MessagePosted;
use App\Events\UserLogin;
use App\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //

    /*
     * get all message
     */
    function index($id , $direct){
        Message::where([ ['is_read',0] , ['direct',$direct] , ['to_user_id',Auth::id()]])->update(['is_read'=>'1' , 'read_at'=>Carbon::now()]);
        return [
            'messages' => Message::where('direct',$direct)->with('from_user')->orderBy('created_at')->get(),
            'user' => User::find($id)
        ];
    }


    function store(Request $request){
        $id = [Auth::id(),$request->id];
        sort($id);
        $message = Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $request->id,
            'body' => $request->msg,
            'direct' => $id[0].$id[1],
        ]);

        $m = Message::where('id',$message->id)->with('from_user')->first();

        if($message){
            broadcast(new MessagePosted($m , $m->from_user, Auth::user()))->toOthers();
            return ['sta'=>1 , 'msg'=>'消息发送成功' , 'message' => $m];
        }
        return ['sta'=>0 , 'msg'=>'消息发送失败'];
    }

    function notify(Request $request){

        broadcast(new UserLogin($request->message));

        return $request->message;
    }

}
