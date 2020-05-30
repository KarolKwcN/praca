@extends('layouts.app')

@section('content')

<div class="pt-5 pb-3 text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-3">Naprawy</h1>
                <p class="lead">Wybierz kategorię</p>
            </div>
        </div>
        <div class="row">
            @foreach($categories as $category)

                <div class="col-md-3 col-6 p-5 text-center">
                    <a href="{{ url('/naprawy', $category->slug) }}">
                        <img class="img-fluid mx-auto d-block img-responsive" src="{{ $category->image }}">
                        <h4 class="mt-3 mb-0"> <b>{{ $category->name }}&nbsp;</b> </h4>
                    </a>
                </div>

            @endforeach
        </div>
    </div>
</div>
@endsection
