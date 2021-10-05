@extends('layouts.site')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <!--Grid column-->
        @if(isset($producys))
            @foreach($producys as $product)
                <div class="col-md-4 mb-4">

                    <div class="card">
                        <div class="card-body text-center">

                            <h5 class="mt-0 mb-1 mb-2">Title
{{--                                {{$product -> name}}--}}
                            </h5>
                            <p class="grey-text mb-2">
                                description
{{--                                {{$product -> description}}--}}
                            </p>
                            <p class="grey-text mb-2">
                                price
{{--                                {{$product -> price}}--}}
                            </p>

                            <img src="https://www.91-img.com/pictures/133432-v4-xiaomi-mi-a3-mobile-phone-large-1.jpg?tr=q-60" class="my-3" alt="Angular logo">

                            <br>

                            <a id="home-updates-angular" href=""
                               role="button" class="btn  btn-success px-3 waves-effect waves-light">التفاصيل
                            </a>
                        </div>

                    </div>

                </div>
        @endforeach
    @endif
    <!--Grid column-->


    </div>
</div>
@endsection;

