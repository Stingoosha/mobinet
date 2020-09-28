@extends('layouts.layout', ['title' => 'Заказ №' . $order['id_order'], 'layout' => $layout])

@section('content')

    <h1 class="display-1 text-info">Детали заказа №{{ $order['id_order'] }}</h1>
    <div class="row">
        <div class="col-7 mx-auto">
            <div class="table-responsive">
            <h3 class="display-3 text-info">Корзина заказа</h3>
            <table class="table text-info">
                <tr class="bg-info">
                    <th>Наименование</th>
                    <th>Количество</th>
                </tr>
                @if (!empty($phones))
                @foreach ($phones as $phone)
                    <tr>
                        <td><a href="/phones/{{ $phone['id_good'] }}"><img src="../{{ $pathImgSmall }}{{ $phone['photo'] ? $phone['photo'] : 'default.jpg' }}">{{ $phone['name_good'] }}</img></a></td>
                        <td>{{ $phone['amount'] }}</td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                @endif
            </table>
            <h3 class="display-3 text-info">Детали заказа</h3>
            <table class="table text-info">
                <tr class="bg-info">
                    <th>Наименование</th>
                    <th>Значение</th>
                </tr>
                <tr>
                    <td>ID заказа</td>
                    <td>{{ $order['id_order'] }}</td>
                </tr>
                <tr>
                    <td>Время заказа</td>
                    <td>{{ $order['created_at'] }}</td>
                </tr>
                <tr>
                    <td>Стоимость заказа</td>
                    <td>{{ $order['price_order'] }}  &#8381;</td>
                </tr>
                <tr>
                    <td>Статус заказа</td>
                    <td>{{ $order['status'] }}</td>
                </tr>
                <tr>
                    <td>Способ доставки</td>
                    <td>{{ $order['delivery_method'] }}</td>
                </tr>
                @if ($layout['user']['id_role'] == 7)
                <tr>
                    <td>ID клиента</td>
                    <td><a class="btn btn-outline-info col-6" href="/users/{{ $order['id_user'] }}">{{ $order['id_user'] }}</a></td>
                </tr>
                @endif
                <tr>
                    <td>Имя клиента</td>
                    <td>{{ $order['first_name'] }}</td>
                </tr>
                <tr>
                    <td>Номер телефона клиента</td>
                    <td>{{ $order['phone'] }}</td>
                </tr>
                <tr>
                    <td>Адрес клиента</td>
                    <td>{{ $order['addresses'] }}</td>
                </tr>
                <tr>
                    <td>Email клиента</td>
                    <td>{{ $order['email'] }}</td>
                </tr>
                <tr>
                    <td>Дисконтная карта</td>
                    <td>{{ $order['discount_card'] }}</td>
                </tr>
                <tr>
                    <td>Комментарий</td>
                    <td>{{ $order['comments'] }}</td>
                </tr>
            </table>
            </div>
            <a class="btn btn-ouline-info col-5" href="/orders"><button class="btn btn-outline-info px-5 col-8">К заказам</button></a>
        </div>
    </div>

@endsection
