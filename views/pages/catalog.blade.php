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
                            <a class="link stretched-link" href="phones/{{ $phone['id_good'] }}"><img src="{{ $pathImgSmall }}{{ $phone['photo'] ? $phone['photo'] : 'default.jpg' }}" class="card-img-top px-3 py-1" alt="Мобила" style="height: 18rem"></a>
                            <div class="card-body">
                                <h5 class="card-title">{{ $phone['name_good'] }}</h5>
                                @if ($phone['new_price'])
                                    <p class="lead text-success font-weight-bold">Цена: <del>{{ $phone['price_good'] }} &#8381;</del></p>
                                    <p class="lead text-warning font-weight-bold">{{ $phone['new_price'] }} &#8381;</p>
                                @else
                                    <p class="lead text-success font-weight-bold">Цена: {{ $phone['price_good'] }} ₽</p>
                                @endif
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
            <button class="mx-auto btn btn-outline-info col-5" id="showMore-btn" onclick="showMore(<?= $phone['id_good'] ?>,<?= $total ?>)">Показать еще...</button>
        </div>

    @endif

@endsection
