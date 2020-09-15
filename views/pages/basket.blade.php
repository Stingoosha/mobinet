@extends('layouts.layout', ['title' => 'Корзина', 'userData' => $userData])

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
                                <td>{{ $order['order_date'] }}</td>
                                <td>{{ $order['order_price'] }} &#8381;</td>
                                <td>{{ $order['first_name'] }}</td>
                                <td>{{ $order['phone'] }}</td>
                                <td>{{ $order['discount_card'] }}</td>
                                <td>{{ $order['delivery_method'] }}</td>
                                <td>{{ $order['addr'] }}</td>
                                <td>{{ $order['comment'] }}</td>
                                <td>{{ $order['order_state'] }}</td>
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
                                $phonePrice = $phone['new_price'] ?? $phone['price'];
                                $summ += ($phone['price'] * $phone['amount']);
                                $summFinal += ($phonePrice * $phone['amount']);
                            ?>
                            <tr>
                                <td><a href="/phones/{{ $phone['good_id'] }}"><img src="{{ $pathImgSmall }}{{ $phone['photo'] ? $phone['photo'] : 'default.jpg' }}">{{ $phone['name'] }}</img></a></td>
                                <td>
                                    @if ($phone['new_price'])
                                        <del>{{ $phone['price'] }} &#8381;</del>&emsp;{{ $phone['new_price'] }} &#8381;
                                    @else
                                        {{ $phone['price'] }} &#8381;
                                    @endif
                                </td>
                                <td>{{ $phone['amount'] }}</td>
                                <td>
                                    @if ($phone['new_price'])
                                        <del><?=$phone['price'] * $phone['amount']?> &#8381;</del>&emsp;<?=$phone['new_price'] * $phone['amount']?> &#8381;
                                    @else
                                        {{ $phone['price'] * $phone['amount'] }} &#8381;
                                    @endif
                                </td>
                                <td><a class="remove" href="/basket/{{ $phone['good_id'] }}/remove">&#10060;</a></td>
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
                    @if ($summFinal !== $summ)
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
