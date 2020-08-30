@extends('layouts.app')

@section('content')
<div id="app_message">
    <div class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="mx-auto text-center col-lg-6">
                    <h1 class="mb-3">Kontakt i informacje</h1>
                    <p class="lead mb-4">Aby skontaktować się z nami wypełnij pola w poniższym formularzu.</p>
                </div>
            </div>
            <div class="row">
                <div class="p-0 order-2 order-md-1 col-lg-6"> <iframe width="100%" height="350"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d150648.5595486463!2d22.869735248653274!3d53.84493162713478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46e0505609dd208d%3A0xea806f10b88a9f4a!2zQXVndXN0w7N3!5e0!3m2!1spl!2spl!4v1598816268398!5m2!1spl!2spl"
                        scrolling="no" frameborder="0"></iframe> </div>
                <div class="px-4 order-1 order-md-2 col-lg-6">

                    <form>
                        <div class="form-group"> <input type="text" class="form-control" id="form44" placeholder="Name">
                        </div>
                        <div class="form-group"> <input type="email" class="form-control" id="form45"
                                placeholder="Email"> </div>
                        <div class="form-group"> <textarea class="form-control" id="form46" rows="3"
                                placeholder="Your message"></textarea> </div> <button type="submit"
                            class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
