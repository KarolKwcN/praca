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
                    {{ $brand->name }}</a>

            </div><br>
            <hr class="bg-info">
            <div class="row">
                <div class="col-lg-12">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center bg-info text-light">
                                <th>Lp.</th>
                                <th>Model</th>
                                <th>Opis</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach($devices as $device)
                                <tr class="text-center">
                                    <td> {{ $i++ }}</td>
                                    <td><a
                                            href="{{ route('serwisant_urzadzenie', ['slug'=> $category->slug , 'slugi' => $brand->slugi, 'slugii' => $device->slugii]) }}">{{ $device->name }}</a>
                                    </td>
                                    <td>
                                        <p>{{ $device->description }}</p>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>

                    </table>
                    <div class="col-12 d-flex justify-content-center">
                        {{ $devices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
