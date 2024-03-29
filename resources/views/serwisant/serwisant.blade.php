@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="">
                        <h5 class="text-info">Naprawy</h5>
                    </a>
                </li>

            </ul>
        </div>
        <div class="card-body">
            <div class="float-left">
                <a class="text-reset" href="">Kategorie</a>
            </div><br>
            <hr class="bg-info">
            <div class="row">
                <div class="col-lg-12">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center bg-info text-light">
                                <th>Lp.</th>
                                <th>Nazwa kategorii</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=($categories->currentpage() - 1) * $categories->perpage()+1; ?>
                            @foreach($categories as $category)
                                <tr class="text-center">
                                    <td> {{ $i++ }}</td>
                                    <td><a
                                            href="{{ route('serwisant_naprawy_marka', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>

                    </table>
                    <div class="col-12 d-flex justify-content-center">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>








@endsection
