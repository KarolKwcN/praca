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

                <div class="col-lg-2 col-md-2 m-2" style="">

                    <div class="row">
                        <div class="col-3 col-md-12 p-2 border" style="">
                            <a href="{{ url('/naprawy', $category->slug) }}">
                                <img style="max-width: 100%;
                                height: 150px;" src="{{ $category->image }}" style="">
                                <div class="col-9 col-md-12">
                                    <p class="lead mb-1"> <b>{{ $category->name }}</b> </p>
                                </div>
                            </a>
                        </div>
                    </div>


                </div>

            @endforeach
        </div>
    </div>
</div>
@endsection
