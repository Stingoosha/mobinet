@extends('layouts/layout', ['title' => 'Главная', 'layout' => $layout])

@section('content')

    <div class="col-8 mx-auto">
        <h1 class="display-1 text-info">Онлайн интернет-магазин &quot;MobiNet&quot;</h1>
        <img src="public/img/phones.png" alt="poster" class="poster">
        <div class="container text-info">
                <p>Наш интернет-магазин предлагает большой выбор мобильных телефонов и смартфонов ОТЛИЧНОГО качества на любой вкус. Мы являемся прямым поставщиком, без посредников.<br><h3 class="display-5 font-weight-bold font-italic">Наши преимущества:</h3></p>
            <ul class="list-group">
                <li class="list-group-item list-group-item-success">ПЕРВЫЕ РУКИ</li>
                <li class="list-group-item list-group-item-danger">ШИРОКИЙ АССОРТИМЕНТ</li>
                <li class="list-group-item list-group-item-warning">ДРОПШИППИНГ</li>
                <li class="list-group-item list-group-item-info">НИЗКИЕ ЦЕНЫ</li>
                <li class="list-group-item list-group-item-success">ДОСТАВКА 1-2 ДНЯ</li>
                <li class="list-group-item list-group-item-danger">НАЛОЖЕННЫЙ ПЛАТЕЖ</li>
                <li class="list-group-item list-group-item-warning">ОБМЕН</li>
                <li class="list-group-item list-group-item-info">БЫСТРАЯ ОБРАТНАЯ СВЯЗЬ</li>
                <li class="list-group-item list-group-item-success">МГНОВЕННЫЕ ОТВЕТЫ</li>
                <li class="list-group-item list-group-item-danger">КАЧЕСТВЕННАЯ КОНСУЛЬТАЦИЯ НАШИХ МЕНЕДЖЕРОВ</li>
            </ul>
        </div>
    </div>

@endsection
