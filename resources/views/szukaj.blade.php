@extends('layouts.app')

@section('content')
<div class="container">

    @if(isset($warunek[0]))
        @if(isset($repairs[0]))
            <div class="col-md-12 mb-3 text-center">
                <h1>Naprawy</h1>
            </div>
            <div class="row">
                @foreach($repairs as $repair)
                    <div class="h-25 col-lg-2">
                        <div class="card">
                            <div class="card-body p-1 m-1">
                                <a
                                    href="{{ url('/naprawa',[$repair->devices->brand->category->slug, $repair->devices->brand->slugi, $repair->devices->slugii, $repair->id, $repair->slugi_repair]) }}">
                                    <img class="img-fluid d-block mb-0 mx-auto img-thumbnail"
                                        src="{{ $repair->image }}" width="150">
                                    <h5>{{ $repair->name }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if(isset($devices[0]))
            <div class="col-md-12 mb-3 text-center">
                <h1>Urządzenia</h1>
            </div>
            <div class="row">
                @foreach($devices as $device)
                    <div class="h-25 col-lg-2">
                        <div class="card">
                            <div class="card-body p-1 m-1">
                                <a
                                    href="{{ url('/naprawy',[$device->brand->category->slug, $device->brand->slugi, $device->slugii]) }}">
                                    <img class="img-fluid d-block mb-0 mx-auto img-thumbnail"
                                        src="{{ $device->image }}" width="150">
                                    <h5>{{ $device->name }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if(isset($brands[0]))
            <div class="col-md-12 mb-3 text-center">
                <h1>Marki</h1>
            </div>
            <div class="row">
                @foreach($brands as $brand)
                    <div class="h-25 col-lg-2">
                        <div class="card">
                            <div class="card-body p-1 m-1">
                                <a
                                    href="{{ url('/naprawy',[$brand->category->slug, $brand->slugi]) }}">
                                    <img class="img-fluid d-block mb-0 mx-auto img-thumbnail"
                                        src="{{ $brand->image }}" width="150">
                                    <h5>{{ $brand->name }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if(isset($categories[0]))
            <div class="col-md-12 mb-3 text-center">
                <h1>Kategorie</h1>
            </div>
            <div class="row">
                @foreach($categories as $category)
                    <div class="h-25 col-lg-2">
                        <div class="card">
                            <div class="card-body p-1 m-1">
                                <a href="{{ url('/naprawy',[$category->slug]) }}">
                                    <img class="img-fluid d-block mb-0 mx-auto img-thumbnail"
                                        src="{{ $category->image }}" width="150">
                                    <h5>{{ $category->name }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        <h1>Brak wyników</h1>
    @endif



</div>
@endsection
