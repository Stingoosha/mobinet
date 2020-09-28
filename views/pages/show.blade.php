@extends('layouts.layout', ['title' => $phone['name_good'], 'layout' => $layout])

@section('content')

    <h1 class="display-1 text-info">{{ $phone['name_good'] }}</h1>
    <div class="row">
        <div class="col-5 mb-3 ml-auto">
            <div class="card-deck text-center">
                <div class="card border-info text-info mb-3 p-3 d-flex flex-row">
                    <div class="card-img col-6">
                        <img class="w-50 card-img-top" src="../{{ $pathImgLarge }}{{ $phone['photo'] ?? 'default.jpg' }}" alt="Мобила">
                    </div>
                    <div class="card-body float-left">
                    @if ($phone['new_price'])
                        <p class="lead text-success font-weight-bold">Цена: <del>{{ $phone['price_good'] }} &#8381;</del></p>
                        <p class="lead text-warning font-weight-bold">{{ $phone['new_price'] }} &#8381;</p>
                    @else
                        <p class="lead text-success font-weight-bold">Цена: {{ $phone['price_good'] }} ₽</p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5 mr-auto">
            @include('partials/buy')
        </div>
    </div>
    <div class="row">
        <div class="accordion col-6 mx-auto mb-3" id="accordionExample">
            <div class="card border border-info">
                <div class="card-header border-bottom border-info" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left text-warning font-weight-bolder font-italic" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Описание</button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <p class="card-text text-info">{{ $phone['description'] }}</p>
                    </div>
                </div>
            </div>
            <div class="card border border-top-0 border-info">
                <div class="card-header border-bottom border-info" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left text-warning font-weight-bolder font-italic collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i>Технические характеристики</i></button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="col-12 mx-auto d-flex">
                            <div class="col-6 pl-3 text-left">
                                <p class="card-text text-info">Год выпуска</p>
                                <p class="card-text text-info">Стандарт</p>
                                <p class="card-text text-info">Операционная система</p>
                                <p class="card-text text-info">Процессор</p>
                                <p class="card-text text-info">Количество SIM-карт</p>
                                <p class="card-text text-info">Диагональ экрана (дюйм)</p>
                                <p class="card-text text-info">Фотокамера (Мп)</p>
                                <p class="card-text text-info">Оперативная память (Мб)</p>
                                <p class="card-text text-info">Встроенная память (Мб)</p>
                                <p class="card-text text-info">Емкость аккумулятора (мАч)</p>
                            </div>
                            <div class="col-6 pr-3 text-right">
                                <p class="card-text text-info">{{ $params['year'] ?? '' }}</p>
                                <p class="card-text text-info">{{ $params['standart'] ?? '' }}</p>
                                <p class="card-text text-info">{{ $params['os'] ?? '' }}</p>
                                <p class="card-text text-info">{{ $params['proc'] ?? '' }}</p>
                                <p class="card-text text-info">{{ $params['sim'] ?? '' }}</p>
                                <p class="card-text text-info">{{ $params['display'] ?? '' }}</p>
                                <p class="card-text text-info">{{ $params['camera'] ?? '' }}</p>
                                <p class="card-text text-info">{{ $params['ram'] ?? '' }}</p>
                                <p class="card-text text-info">{{ $params['rom'] ?? '' }}</p>
                                <p class="card-text text-info">{{ $params['battery'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="/phones" class="col-2 mx-auto"><button class="btn btn-outline-info px-5">В каталог</button></a>

@endsection
