@extends('layouts.layout', ['title' => $phone['name']])

@section('content')

    <h1 class="display-1 text-info">{{ $phone['name'] }}</h1>
    <div class="row">
        <div class="col-6 mb-3 mx-auto">
            <div class="card-deck text-center">
                <div class="card border-info text-info mb-3">
                    <img class="w-25 card-img-top" src="../{{ $pathImgLarge }}{{ $phone['photo'] ? $phone['photo'] : 'default.jpg' }}" alt="Мобила">
                    <div class="card-body">
                    <h5 class="card-content">{{ $phone['short_desc'] }}</h5>
                    @if ($phone['new_price'])
                        <p class="card-text text-success font-weight-bold">Цена:&emsp;<del>{{ $phone['price'] }} &#8381;</del>&emsp;{{ $phone['new_price'] }} &#8381;</p>
                    @else
                        <p class="card-text text-success font-weight-bold">Цена: {{ $phone['price'] }} ₽</p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            @include('partials/buy')
        </div>
    </div>
    <a href="/phones" class="col-2 mx-auto"><button class="btn btn-outline-info px-5">В каталог</button></a>

@endsection
