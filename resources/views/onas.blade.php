@extends('layouts.app')

@section('content')
<div id="app_message">
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Krótko o nas</h1>
                    <p class="mb-4">Domowy Serwis to portal mający na celu uproszczenie napraw dla każdego człowieka.
                        Jest on
                        swego rodzaju przewodnikiem, który poprowadzi użytkownika przez naprawę i w łatwy sposób,
                        krok po kroku pokazuje jak naprawić zepsuty sprzęt. Na naszej stronie znajdziesz instrukcje jak
                        naprawić zarówno smartfona, laptopa czy komputer stacjonarny. </p>
                    <div class="row">
                        <div class="col-md-4 order-3 order-md-1 float-left"> <img class="img-fluid d-block"
                                src="images/P08163738a.jpg"> </div>
                        <div class=" col-md-6 col-8 d-flex flex-column justify-content-center p-3 order-1 order-md-2">
                            <h3>Napraw to</h3>
                            <p>Masz zepsuty sprzęt, którego nie potrafisz uratować? Znajdź naprawę,
                                której szukasz, zarejstruj się i dodawaj komentarze.</p>
                            <p> Nie wyrzucaj starego sprzętu,
                                daj mu nowe życie i ratuj naszą planetę!</p>

                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-4 order-3 order-md-1"> <img class="img-fluid d-block" src="images/66543.jpg">
                        </div>
                        <div class="col-md-6 col-8 d-flex flex-column justify-content-center p-3 order-1 order-md-2">
                            <h3>Zostań serwisantem</h3>
                            <p>Jesteś osobą która interesuje się naprawami sprzętów elektronicznych? Nasza strona jest
                                właśnie dla Ciebie! Skontaktuj się z nami, zostań serwisantem i twórz własne poradniki.
                            </p>
                        </div>
                    </div>


                    <br><br>
                    {{-- <div>
                         <div class="col-md-4 order-3 order-md-1 float-right"> <img class="img-fluid d-block"
                                 src="images/3425.jpg"> </div>
                         <div class="col-md-6 col-8 d-flex flex-column justify-content-center p-3 order-1 order-md-2">
                             <h3>Ekologia</h3>
                             <p>Jako mieszkańcy planety powinniśmy o nią dbać. Zamiast kupować nowy model powinniśmy
                                 postarać się naprawić stary sprzęt. Fabryki podczas produkcji zużywają wiele surowców
                                 naturalnych oraz produkują znaczne ilości dwutlenku węgla.
                             </p>
                         </div>
                     </div> --}}
                </div>
            </div>
        </div>
    </div>



</div>
@endsection
