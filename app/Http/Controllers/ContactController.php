<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Mail;

class ContactController extends Controller
{
    public function wyslij(Request $request){

$messages = [              
                    "name.required" => 'Imię jest wymagane',
                    "email.required" => 'Email jest wymagany',
                    
                    "email.email" => "Email jest niepoprawny",
                    "message_body.required" => "Wiadomość jest wymagana",
                    "message_body.min" => "Wiadomość musi mieć minimalnie 20 znaków",
                ];


        $this->validate($request, ['name' => 'required', 'email' => 'required|email', 'message_body' => 'required|min:20'],$messages);

        $data = array('name' => $request->name , 'email' => $request->email , 'message_body' => $request->message_body );

        Mail::send('emails.email', $data, function ($message) use ($data)
        {
            $message->from($data['email'], $data['name']);
            $message->to('karol.kwiecien91@gmail.com', 'Admin')
                ->subject('Domowy Serwis');
        });

        return redirect()
            ->back()
            ->with('success', 'Wiadomość została wysłana');
    }
}
