@extends('layouts.app')

@section('content')
<div class="py-5 text-center" style="background-image: url('images/543654745672.jpg');background-size:cover;">
    <div class="row">
        <div class="mx-auto col-md-6 col-10 bg-white p-5 rounded">
            <h1 class="mb-4">Rejestracja</h1>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <input type="text" placeholder="Nazwa użytkownika"
                        class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="form-group">
                    <input type="email" placeholder="Wprowadź email"
                        class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Hasło"
                        class="form-control @error('password') is-invalid @enderror" name="password" required
                        autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="form-group"> <input type="password" class="form-control" placeholder="Powtórz hasło"
                        name="password_confirmation" required autocomplete="new-password">
                    <small class="form-text text-muted text-right">
                    </small> </div> <button type="submit" class="btn btn-primary">Zarejestruj</button>
            </form>
        </div>
    </div>
</div>
@endsection
