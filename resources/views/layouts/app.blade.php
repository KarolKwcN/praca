<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4286317d70.js" crossorigin="anonymous"></script> 

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light" style="">
            <div class="container"> <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar7">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbar7"> <a class="navbar-brand text-primary d-none d-md-block" href="{{url('/')}}">
                  <i class="fas fa-screwdriver"></i>
                  <b>DOMOWY SERWIS</b>
                </a>
                <ul class="navbar-nav mx-auto">
                  <li class="nav-item"> <a class="nav-link" href="{{url('/naprawy')}}">Naprawy</a> </li>
                  <li class="nav-item"> <a class="nav-link" href="#">O nas</a> </li>
                  <li class="nav-item"> <a class="nav-link" href="#">Kontakt</a> </li>
                  @if(Auth::check())
                  @if(Auth::user()->hasRole('Admin'))
                    <li class="nav-item"> <a class="nav-link" href="#">Panel admina</a> </li>
                    @endif
                    @if(Auth::user()->hasRole('Serwisant'))
                    <li class="nav-item"> <a class="nav-link" href="#">Panel serwisanta</a> </li>
                    @endif
                    @endif
                </ul>
                <ul class="navbar-nav">
                
                     @if (Auth::check())
                     <li class="nav-item"><a class="nav-link">{{Auth::user()->name}}</a></li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ url('/wiadomosci')}}">
                          <i class="fas fa-envelope"></i></a></li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{ url('/logout')}}">
                          <i class="fas fa-user"></i></a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/logout')}}">
                        <i class="fas fa-sign-out-alt"></i>
                        </a> </li>
                    @else
                        <li class="nav-item"> <a class="nav-link" href="{{route('login')}}">Zaloguj
                        <i class="fas fa-sign-in-alt"></i>
                         </a> </li>
                         <li class="nav-item"> <a class="nav-link" href="{{route('register')}}">Zarejestrój
                        <i class="fas fa-key"></i>
                         </a> </li>
                    @endif
        
                </ul>
              </div>
            </div>
          </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
