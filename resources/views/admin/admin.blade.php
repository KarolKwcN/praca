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
                    <a class="nav-link" href="{{ route('admin.repairs') }}">
                        <h5 class="text-info">Naprawy</h5>
                    </a>
                </li>
            </ul>
        </div>
        <adminuser-component></adminuser-component>
    </div>

</div>
@endsection
