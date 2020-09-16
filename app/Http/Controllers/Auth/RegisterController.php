<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Role;
use App\VerifyUser;
use App\Mail\VerifyMail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
          ]);
          $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => sha1(time())
          ]);
          \Mail::to($user->email)->send(new VerifyMail($user));

    //przypisywanie domyślnej wartości user w tabeli user_role
    $role_user = Role::where('name',  'User')->first();
    $user->roles()-> attach($role_user);

    return $user;

    }

    public function verifyUser($token)
{
  $verifyUser = VerifyUser::where('token', $token)->first();
  if(isset($verifyUser) ){
    $user = $verifyUser->user;
    if(!$user->verified) {
      $verifyUser->user->verified = 1;
      $verifyUser->user->save();
      $status = "Twój e-mail jest zweryfikowany. Możesz się teraz zalogować.";
    } else {
      $status = "Twój adres e-mail jest już zweryfikowany. Możesz się teraz zalogować.";
    }
  } else {
    return redirect('/login')->with('warning', "Przepraszamy, nie można zidentyfikować Twojego adresu e-mail.");
  }
  return redirect('/login')->with('status', $status);

}

protected function registered(Request $request, $user)
{
  $this->guard()->logout();
  return redirect('/login')->with('status', 'Wysłaliśmy Ci kod aktywacyjny. Sprawdź swoją skrzynkę e-mail i kliknij link, aby zweryfikować.');
}

}
