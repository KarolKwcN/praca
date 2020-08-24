<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use App\Events\MessageEvent;

class MessageController extends Controller
{
    public function getMessages(){
    $allUsers1 = User::with('roles')
    ->select('users.*','conversation.updated_at')
    ->Join('conversation','users.id','conversation.user_one')
    ->where('conversation.user_two',Auth::user()->id)->get();
    //return $allUsers1;

    $allUsers2 = User::with('roles')
    ->select('users.*','conversation.updated_at')
    ->Join('conversation','users.id','conversation.user_two')
    ->where('conversation.user_one',Auth::user()->id)->get();
    return array_merge($allUsers1->toArray(), $allUsers2->toArray());
    }

    public function getMessagesID($id){

      
        $checkCon1 = DB::table('conversation')->where('user_one',Auth::user()->id)
        ->where('user_two',$id)->get(); 

        $checkCon2 = DB::table('conversation')->where('user_two',Auth::user()->id)
        ->where('user_one',$id)->get(); 

        $allCons = array_merge($checkCon1->toArray(),$checkCon2->toArray());

        if(count($allCons)!=0)
        {
        $userMsg = DB::table('messages')
        ->join('users','users.id','messages.user_from')
        ->where('messages.conversation_id', $allCons[0]->id)
        ->select(
                  'messages.*',
                  'users.name',            
          )
        ->get();
        return $userMsg;
         }
    }


      public function sendMessage(Request $request){
        $conID = $request->conID;
        $msg = $request->msg;
  
        $checkUserId = DB::table('messages')->where('conversation_id', $conID)->get();
        if($checkUserId[0]->user_from== Auth::user()->id){
          // fetch user_to
          $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)
          ->get();
            $userTo = $fetch_userTo[0]->user_to;
        }else{
        // fetch user_to
        $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)
        ->get();
          $userTo = $fetch_userTo[0]->user_to;
        }
  
          // now send message
          $sendM = DB::table('messages')->insert([
            'user_to' => $userTo,
            'user_from' => Auth::user()->id,
            'msg' => $msg,
            'status' => 0,
            'conversation_id' => $conID,
            'created_at' =>  Carbon::now()->toDateTimeString()

          ]);
          if($sendM){
            $userMsg = DB::table('messages')
            ->join('users', 'users.id','messages.user_from')
            ->where('messages.conversation_id', $conID)->get();

            DB::table('conversation')
            ->where('id', $conID)
            ->update(['updated_at' =>  Carbon::now()->toDateTimeString()]);

            $user = User::find(Auth::id());
            event(new MessageEvent($msg,$user));

            return $userMsg;
          }
    }
    public function getUsers()
    {
         $uid = Auth::user()->id;
  
        $allUsers = User::with('roles')
        ->select('users.*')
        ->where('id', '!=', Auth::user()->id)
        ->get();

        return $allUsers;

    }

    public function sendNewMessage(Request $request){
        $msg = $request->msg;
        $user_id = $request->user_id;
        $myID = Auth::user()->id;

        //check if conversation already started or not
        $checkCon1 = DB::table('conversation')->where('user_one',$myID)
        ->where('user_two',$user_id)->get(); // if loggedin user started conversation

        $checkCon2 = DB::table('conversation')->where('user_two',$myID)
        ->where('user_one',$user_id)->get(); // if loggedin recviced message first

        $allCons = array_merge($checkCon1->toArray(),$checkCon2->toArray());

        if(count($allCons)!=0){
          // old conversation
          $conID_old = $allCons[0]->id;
          //insert data into messages table
          $MsgSent = DB::table('messages')->insert([
            'user_from' => $myID,
            'user_to' => $user_id,
            'msg' => $msg,
            'conversation_id' =>  $conID_old,
            'status' => 0,
            'created_at' =>  Carbon::now()->toDateTimeString()
          ]);
          if($MsgSent){
            $userMsg = DB::table('messages')
            ->join('users', 'users.id','messages.user_from')
            ->where('messages.conversation_id', $conID_old)->get();

              DB::table('conversation')
            ->where('id', $conID_old)
            ->update(['updated_at' =>  Carbon::now()->toDateTimeString()]);

             $user = User::find(Auth::id());
            event(new MessageEvent($msg,$user));

            return $userMsg;
          }
        }else {
          // new conversation
          $conID_new = DB::table('conversation')->insertGetId([
            'user_one' => $myID,
            'user_two' => $user_id,
            'created_at' =>  Carbon::now()->toDateTimeString(),
            'updated_at' =>  Carbon::now()->toDateTimeString()
          ]);
          

          $MsgSent = DB::table('messages')->insert([
            'user_from' => $myID,
            'user_to' => $user_id,
            'msg' => $msg,
            'conversation_id' =>  $conID_new,
            'status' => 1,
            'created_at' =>  Carbon::now()->toDateTimeString()
          ]);
              if($MsgSent){
            $userMsg = DB::table('messages')
            ->join('users', 'users.id','messages.user_from')
            ->where('messages.conversation_id', $conID_new)->get();

                DB::table('conversation')
            ->where('id', $conID_new)
            ->update(['updated_at' =>  Carbon::now()->toDateTimeString()]);

             $user = User::find(Auth::id());
            event(new MessageEvent($msg,$user));

            return $userMsg;
          }
        }
         
    }
}
