@extends('layouts.app')

@section('content')
<div class="pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"> <a href="{{ url('/naprawy') }}">Kategorie</a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('naprawa.marka', $category->slug) }}">{{ $category->name }}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('naprawa.device',[$category->slug, $brand->slugi]) }}">{{ $brand->name }}</a>
                    </li>
                    <li class="breadcrumb-item active"><a
                            href="{{ route('naprawa.repairs',[$category->slug, $brand->slugi, $device->slugii]) }}">{{ $device->name }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>{{ $device->name }}</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach($repairs as $repair)
                <div class="col-lg-5 col-md-6 p-3">
                    <div class="row">
                        <div class="col-3 p-0">
                            <a
                                href="{{ url('/naprawa',[$category->slug, $brand->slugi, $device->slugii, $repair->id, $repair->slugi_repair]) }}">
                                <img class="img-fluid d-block" src="{{ $repair->image }}"> </div>
                        <div class="col-9">
                            <p class="mb-0">{{ $repair->name }}</p>
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
