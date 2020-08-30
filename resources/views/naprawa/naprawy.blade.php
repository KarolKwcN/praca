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


<div class="py-4 text-center">
    <div class="container">

        <h1>{{ $device->name }}</h1>
        <div class="row">
            @foreach($repairs as $repair)
                <div class="h-25 col-lg-2">
                    <div class="card">
                        <div class="card-body p-1 m-1">
                            <a
                                href="{{ url('/naprawa',[$category->slug, $brand->slugi, $device->slugii, $repair->id, $repair->slugi_repair]) }}">
                                <img class="img-fluid d-block mb-0 mx-auto img-thumbnail" src="{{ $repair->image }}"
                                    width="150">
                                <h5>{{ $repair->name }}</h5>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    @endsection
