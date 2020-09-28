@extends('layouts.layout', ['title' => 'Корзина', 'layout' => $layout])

@section('content')

    <div class="row">
        <div class="col-12 mx-auto">
            <div class="orders-info">
                <h1 class="display-1 text-info">Ваши заказы</h1>
                <div class="table-responsive">
                    <table class="table text-info">
                        <tr class="bg-info">
                            <th>Время заказа</th>
                            <th>Стоимость заказа</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Дисконтная карта</th>
                            <th>Способ доставки</th>
                            <th>Адрес</th>
                            <th>Комментарий</th>
                            <th>Состояние</th>
                        </tr>
                    @if (!empty($orders))
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order['created_at'] }}</td>
                                <td>{{ $order['price_order'] }} &#8381;</td>
                                <td>{{ $order['first_name'] }}</td>
                                <td>{{ $order['phone'] }}</td>
                                <td>{{ $order['discount_card'] }}</td>
                                <td>{{ $order['delivery_method'] }}</td>
                                <td>{{ $order['addresses'] }}</td>
                                <td>{{ $order['comments'] }}</td>
                                <td>{{ $order['status'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    </table>
                </div>
            </div>
            <div class="basket-info">
                <h1 class="display-1 text-info">Ваша корзина</h1>
                <div class="table-responsive">
                    <table class="table text-info">
                        <tr class="bg-info">
                            <th>Наименование</th>
                            <th>Стоимость</th>
                            <th>Количество</th>
                            <th>Сумма</th>
                            <th>Удалить</th>
                        </tr>
                        @if (!empty($phones))
                        @foreach ($phones as $phone)
                            <?php
                                $phonePrice = empty((int)$phone['new_price']) ? $phone['price_good'] : $phone['new_price'];
                                $summ += ($phone['price_good'] * $phone['amount']);
                                $summFinal += ($phonePrice * $phone['amount']);
                            ?>
                            <tr>
                                <td><a href="/phones/{{ $phone['id_good'] }}"><img src="{{ $pathImgSmall }}{{ $phone['photo'] ? $phone['photo'] : 'default.jpg' }}">{{ $phone['name_good'] }}</img></a></td>
                                <td>
                                    @if ($phone['new_price'])
                                        <del>{{ $phone['price_good'] }} &#8381;</del>&emsp;{{ $phone['new_price'] }} &#8381;
                                    @else
                                        {{ $phone['price_good'] }} &#8381;
                                    @endif
                                </td>
                                <td>{{ $phone['amount'] }}</td>
                                <td>
                                    @if ($phone['new_price'])
                                        <del><?=$phone['price_good'] * $phone['amount']?> &#8381;</del>&emsp;<?=$phone['new_price'] * $phone['amount']?> &#8381;
                                    @else
                                        {{ $phone['price_good'] * $phone['amount'] }} &#8381;
                                    @endif
                                </td>
                                <td><a class="remove" href="/basket/{{ $phone['id_good'] }}/remove">&#10060;</a></td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                    </table>
                </div>
                @if (!empty($phones))
                <p class="total lead">ИТОГО:&emsp;
                    @if ($summFinal !== $summ && $summFinal)
                        <del><?=$summ?> &#8381;</del>&emsp;{{ $summFinal }} &#8381;
                    @else
                        {{ $summ }} &#8381;
                    @endif
                </p>
                <div class="btns text-center">
                    <a href="/order" class="mx-auto"><button class="btn btn-outline-success px-5 col-5">Оформить заказ</button></a>
                </div>
                @endif
            </div>
        </div>
    </div>


@endsection
