@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('serwisant.serwisant') }}">
                        <h5 class="text-info">Naprawy</h5>
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="float-left">
                <a class="text-reset" href="{{ route('serwisant.serwisant') }}">Kategorie </a>>
                <a class="text-reset"
                    href="{{ route('serwisant_naprawy_marka',$category->slug) }}">
                    {{ $category->name }} </a>>
                <a class="text-reset"
                    href="{{ route('serwisant_naprawy_model',['slug'=> $category->slug , 'slugi' => $brand->slugi]) }}">
                    {{ $brand->name }} </a>>
                <a class="text-reset"
                    href="{{ route('serwisant_urzadzenie',['slug'=> $category->slug , 'slugi' => $brand->slugi, 'slugii'=> $device->slugii]) }}">
                    {{ $device->name }}</a>

            </div><br>
            <hr class="bg-info">

            @if(Auth::user()->hasRole('Admin'))
                <serwisantcreaterepair-component :device="{{ $device->id }}" :user_id="{{ Auth::user()->id }}"
                    :isadmin=" 1 "></serwisantcreaterepair-component>
            @else
                <serwisantcreaterepair-component :device="{{ $device->id }}" :user_id="{{ Auth::user()->id }}">
                </serwisantcreaterepair-component>
            @endif

        </div>
    </div>
</div>




@endsection
