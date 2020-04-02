<!DOCTYPE html>
<html>
  <head>
    <title>Domowy serwis</title>
  </head>
  <body>
    <h2>Witamy na stronie {{$user['name']}}</h2>
    <br/>
    Twój zarejestrowany email: {{$user['email']}} , Prosimy kliknąć poniżej w link aktywacyjny w celu aktywacji konta
    <br/>
    <a href="{{url('user/verify', $user->verifyUser->token)}}">Weryfikuj Email</a>
  </body>
</html>