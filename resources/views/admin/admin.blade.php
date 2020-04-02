@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin') }}">
                        <h5 class="text-info">Użytkownicy</h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <h5 class="text-info">Naprawy</h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <hr class="bg-info">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center bg-info text-light">
                                <th>Lp.</th>
                                <th>Imię</th>
                                <th>E-Mail</th>
                                <th>Ban</th>
                                <th>User</th>
                                <th>Serwisant</th>
                                <th>Admin</th>
                                <th>Zatwierdz</th>
                                <th>Usuń</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach($users as $user)

                                <tr class="text-center">
                                    <form action="#" method="post">
                                        @csrf
                                        <td> {{ $i++ }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }} <input type="hidden" name="email"
                                                value="{{ $user->email }}"></td>
                                        <td>
                                           <ban-component></ban-component>
                                        </td>

                                        <td> <input type="checkbox"
                                                {{ $user->hasRole('User') ? 'checked' : '' }}
                                                name="role_user"></td>
                                        <td> <input type="checkbox"
                                                {{ $user->hasRole('Serwisant') ? 'checked' : '' }}
                                                name="role_serwisant"></td>
                                        <td> <input type="checkbox"
                                                {{ $user->hasRole('Admin') ? 'checked' : '' }}
                                                name="role_admin"></td>
                                        <td><button class="btn btn-primary" type="submit">Dodaj role</button></td>

                                    </form>
                                    <td>

                                        <button type="button" class="btn btn-danger" data-userid={{ $user->id }}
                                            data-toggle="modal" data-target="#delete">Usuń użytkownika</button>


                                    </td>
                                </tr>

                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
