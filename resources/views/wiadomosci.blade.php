@extends('layouts.app')

@section('content')
<messages-component :user_id="{{ Auth::user()->id }}"></messages-component>

@endsection
