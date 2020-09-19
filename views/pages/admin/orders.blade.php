@extends('layouts.layout', ['title' => 'Заказы', 'userData' => $userData])

@section('content')

    <h1 class="display-1 text-info">Заказы</h1>
    <div class="row">
        <div class="col-10 mx-auto">
            <div class="table-responsive">
                <table class="table text-info">
                    <tr class="bg-info">
                        <th>ID</th>
                        <th>Заказ</th>
                        <th>Время заказа</th>
                        <th>Стоимость заказа</th>
                        <th>Статус заказа</th>
                        <th></th>
                    </tr>
                @if (!empty($orders))
                    @foreach ($orders as $order)
                    <tr>
                            <form action="/orders/{{ $order['order_id'] }}/edit" method="post">
                                <td class="{{ $order['order_id'] == $newOrderId ? 'bg-success text-light' : '' }}">{{ $order['order_id'] }}</td>
                                <td><a class="btn btn-outline-info" href="/orders/{{ $order['order_id'] }}">Детали заказа</a></td>
                                <td class="{{ $order['order_id'] == $newOrderId ? 'bg-success text-light' : '' }}">{{ $order['order_date'] }}</td>
                                <td class="{{ $order['order_id'] == $newOrderId ? 'bg-success text-light' : '' }}">{{ $order['order_price'] }}  &#8381;</td>
                                <td><select class="form-control w-100" name="newStatus">
                                @foreach ($statuses as $status)
                                    <option {{ $order['status'] == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                                </select></td>
                                <td><input type="submit" value="Изменить" class="btn btn-outline-success"></td>
                            </form>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
                </table>
            </div>
        </div>
    </div>

@endsection
