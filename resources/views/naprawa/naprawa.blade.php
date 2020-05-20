@extends('layouts.app')

@section('content')

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="px-lg-5 d-flex flex-column justify-content-center col-lg-6">
                <h1>{{ $repair->name }}</h1>
                <p class="mb-3 lead">{{ $repair->description }}</p>
            </div>
            <div class="col-lg-6"> <img width="350" style="border-radius: 1%"  class="img-fluid d-block" src="{{ $repair->image }}"> </div>
        </div>
    </div>
</div>

<naprawa-component :repair="{{ $repair->id }}"></naprawa-component>


@endsection