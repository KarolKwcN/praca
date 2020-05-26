@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin') }}">
                        <h5 class="text-info">Użytkownicy</h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.repairs') }}">
                        <h5 class="text-info">Naprawy</h5>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="float-left col-md-6">
                    <a class="text-reset" href="{{ route('admin.repairs') }}">Kategorie </a>>
                    <a class="text-reset"
                        href="{{ route('admin.repairs.marka',$category->slug) }}">{{ $category->name }}</a>
                </div>
                <div class="col-md-6">
                    <img width="60px" class="img-fluid d-block new2 mx-2 float-right" src="{{ $category->image }}" />
                </div>
            </div>
            <br />
            <hr class="bg-info" />
            <adminmarka-component :category="{{ $category->id }}"></adminmarka-component>
        </div>
    </div>

</div>
@endsection
