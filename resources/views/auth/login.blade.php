@extends('layouts.app')

@section('content')
<div class="py-5 text-center" style="background-image: url('images/543654745672.jpg');background-size:cover;">
    <div class="row">
        <div class="mx-auto col-md-6 col-10 bg-white p-5 rounded">
            <h1 class="mb-4">Logowanie</h1>
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif
            @if(session('message'))
                <div class="alert alert-danger">{{ session('message') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group"> <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="form-group mb-3"> <input id="password" type="password" placeholder="Hasło"
                        class="form-control @error('password') is-invalid @enderror" name="password" required
                        autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                </div>



                <button type="submit" class="btn btn-primary">Zaloguj</button>

                @if(Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Zapomniałeś hasła?') }}
                    </a>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
