<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Mail;

class ContactController extends Controller
{
    public function wyslij(Request $request){


        $this->validate($request, ['name' => 'required', 'email' => 'required|email', 'message_body' => 'required|min:20']);

        $data = array('name' => $request->name , 'email' => $request->email , 'message_body' => $request->message_body );

        Mail::send('emails.email', $data, function ($message) use ($data)
        {
            $message->from($data['email'], $data['name']);
            $message->to('karol.kwiecien91@gmail.com', 'Admin')
                ->subject('Laravel Article Feedback');
        });

        return redirect()
            ->back()
            ->with('success', 'Thank you for your feedback');
    }
}
