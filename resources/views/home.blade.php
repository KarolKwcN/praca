@extends('layouts.app')

@section('content')
<div class="py-5 text-center text-md-left" style="background-image: url(images/3395662.jpg); background-position: right bottom; background-size: cover; background-repeat:
    repeat; background-attachment: fixed;">
    <div class="container">
        <div class="row">
            <div class="p-3 mx-auto mx-md-0 mr-md-auto col-10 col-md-7">
                <h3 class="display-3">Wyszukaj</h3>
                <p class="mb-3 lead">Lorem Ipsum jest tekstem stosowanym jako przykładowy wypełniacz w przemyśle
                    poligraficznym. Został po raz pierwszy użyty w XV w. przez nieznanego drukarza do wypełnienia
                    tekstem próbnej książki.</p>
                <form action="{{ route('wyszukaj.naprawe') }}" method="GET"
                    class="form-inline d-flex">
                    <div class="input-group"> <input type="text" class="form-control"
                            placeholder="Wymiana ekranu iphone" id="formcover1" name="s">
                        <div class="input-group-append"> <button class="btn btn-primary" type="submit">Szukaj</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="py-5 text-center">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-lg-10">
                <h1>Naprawiaj z nami</h1>
                <p class="mb-3 mx-auto w-75 lead">Kategorie najczęstrzych napraw. Wybierz co Cię interesuje i napraw to.
                </p>
                <div class="row">
                    <div class="col-md-3 mt-4 px-4 col-6">
                        <a href="{{ url('/naprawy/telefony') }}"><i
                                class="fas fa-mobile-alt fa-7x"></i></a>
                        <h5 class="mt-2"> <b>Smartfony</b></h5>
                        <p class="mb-3">I should be incapable of drawing a single stroke.</p>
                    </div>
                    <div class="col-md-3 mt-4 px-4 col-6"> <a
                            href="{{ url('/naprawy/laptopy') }}"><i
                                class="fas fa-laptop fa-7x"></i></a>
                        <h5 class="mt-2"> <b>Laptopy</b></h5>
                        <p class="mb-3">A wonderful serenity has taken possession.</p>
                    </div>
                    <div class="col-md-3 mt-4 px-4 col-6"> <a href="/"><i class="fas fa-print fa-7x"></i></a>
                        <h5> <b>Drukarki</b> </h5>
                        <p class="mb-3">Like these sweet mornings of spring.</p>
                    </div>
                    <div class="col-md-3 mt-4 px-4 col-6"> <a href="/"><i class="fab fa-windows fa-7x"></i></a>
                        <h5> <b>Systemowe</b> </h5>
                        <p class="mb-3">I enjoy with my whole heart.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="py-5 text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-8 order-2 order-lg-1"> <img class=" img-fluid d-block mb-0 mx-auto img-thumbnail"
                    src={{ $repair->image }}>
            </div>

            <div class="col-lg-2 col-4 d-flex flex-column justify-content-between order-3 order-lg-2">
                @foreach($images as $image)
                    <img class=" img-fluid d-block mb-2 mx-auto img-thumbnail" src={{ $image->image }}>
                @endforeach
            </div>
            <div class="px-md-5 p-3 d-flex flex-column justify-content-center col-lg-6 order-1 order-lg-3">

                <h1>Najnowsza naprawa</h1>
                <a
                    href="{{ url('/naprawa',[$repair->devices->brand->category->slug, $repair->devices->brand->slugi, $repair->devices->slugii, $repair->id, $repair->slugi_repair]) }}">

                    <h3>{{ $repair->name }}</h3>
                </a>
                <p class="lead">{{ $repair->description }}</p>

            </div>
        </div>
    </div>
</div>
<div class="py-5" style="background-image: url(images/34532.jpg); background-position: right bottom; background-size: cover;
    background-repeat: repeat; background-attachment: fixed;">
    <div class="container">
        <div class="row">
            <div class="ml-auto p-3 col-md-2 bg-white"> <img class="img-fluid d-block rounded-circle"
                    src="images/15710.jpg"> </div>
            <div class="p-3 col-md-7 mr-auto bg-white text-dark">
                <div class="blockquote mb-0">
                    <p>"A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring
                        which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot,
                        which was created for the bliss of souls like mine."</p>
                    <div class="blockquote-footer"> <b>J. W. Goethe</b>, CEO at Werther Inc.</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
