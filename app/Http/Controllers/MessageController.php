<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class MessageController extends Controller
{
    public function getMessages(){
    $allUsers1 = User::with('roles')
    ->select('users.*')
    ->Join('conversation','users.id','conversation.user_one')
    ->where('conversation.user_two',Auth::user()->id)->get();
    //return $allUsers1;

    $allUsers2 = User::with('roles')
    ->select('users.*')
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

    if(count($allCons)!=0){
        
        $userMsg = DB::table('messages')
        ->join('users','users.id','messages.user_from')
        ->where('messages.conversation_id', $allCons[0]->id)
        ->select(
                  'messages.*',
                  'users.name',
                  
          )
        ->get();
        return $userMsg;
    }else{
        echo "no messages";
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
            'status' => 1,
            'conversation_id' => $conID
          ]);
          if($sendM){
            $userMsg = DB::table('messages')
            ->join('users', 'users.id','messages.user_from')
            ->where('messages.conversation_id', $conID)->get();
            return $userMsg;
          }
    }
}
