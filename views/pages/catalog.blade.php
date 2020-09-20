@extends('layouts.layout', ['title' => 'Каталог', 'layout' => $layout])

@section('content')

    <h1 class="display-1 text-info">Наш каталог</h1>
    <div class="row">
        <div class="col-2 card border-info h-200">
            <h5 class="text-info">Бренды</h5>
            <div class="col-12 d-flex flex-column" id="brands">

                @foreach ($brands as $brand)

                    <div class="form-check form-check-inline text-info">
                        <input class="form-check-input checkbox brand" type="checkbox" value="{{ $brand['id_brand'] }}">
                        <label class="form-check-label" for="{{ $brand['id_brand'] }}">{{ $brand['name_brand'] }}</label>
                    </div>

                    @endforeach

                    <div class="btns text-center">
                        <a href="/phones"><button class="mx-auto btn btn-outline-info col-10 mb-3">Сбросить</button></a>
                    </div>

            </div>
        </div>
        <div class="col-10">
            <div class="row row-cols-1 row-cols-md-3" id="showMore-container">

                @foreach ($phones as $phone)

                    <div class="col-2 mb-3">
                        <div class="card-deck">
                            <div class="card border-info text-info mb-3 h-100">
                            <a class="link stretched-link" href="phones/{{ $phone['id'] }}"><img src="{{ $pathImgSmall }}{{ $phone['photo'] ? $phone['photo'] : 'default.jpg' }}" class="card-img-top" alt="Мобила"></a>
                            <div class="card-body">
                                <h5 class="card-title">{{ $phone['name'] }}</h5>
                                <p class="card-text text-success font-weight-bold">{{ $phone['price'] }} &#8381;</p>
                            </div>
                            </div>
                        </div>
                        @include('partials/buy')
                    </div>

                @endforeach

            </div>
        </div>
    </div>

    @if (!isset($_POST['search']))

        <div class="btns text-center" id="showMore-div">
            <button class="mx-auto btn btn-outline-info col-5" id="showMore-btn" onclick="showMore(<?= $phone['id'] ?>,<?= $total ?>)">Показать еще...</button>
        </div>

    @endif

@endsection
