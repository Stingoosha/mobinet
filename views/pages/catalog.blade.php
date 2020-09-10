@extends('layouts.layout', ['title' => 'Каталог'])

@section('content')

    <h1 class="display-1 text-info">Наш каталог</h1>
    <div class="row row-cols-1 row-cols-md-3" id="getPhones-container">

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
            </div>

        @endforeach

    </div>
    <div class="btns text-center">
        <button class="mx-auto btn btn-outline-info col-5" id="getPhones-btn" onclick="loadMore(<?= $phone['id'] ?>,<?= $total ?>)">Показать еще...</button>
    </div>


@endsection
