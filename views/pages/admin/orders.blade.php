@extends('layouts.layout', ['title' => 'Заказы', 'layout' => $layout])

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
                            <form action="/orders/{{ $order['id_order'] }}/edit" method="post">
                                <td class="{{ $order['id_order'] == $newOrderId ? 'bg-success text-light' : '' }}">{{ $order['id_order'] }}</td>
                                <td class="{{ $order['id_order'] == $newOrderId ? 'bg-success text-light' : '' }}"><a class="{{ $order['id_order'] == $newOrderId ? 'bg-success text-light border-light' : '' }} btn btn-outline-info" href="/orders/{{ $order['id_order'] }}">Детали заказа</a></td>
                                <td class="{{ $order['id_order'] == $newOrderId ? 'bg-success text-light' : '' }}">{{ $order['created_at'] }}</td>
                                <td class="{{ $order['id_order'] == $newOrderId ? 'bg-success text-light' : '' }}">{{ $order['price_order'] }}  &#8381;</td>
                                <td class="{{ $order['id_order'] == $newOrderId ? 'bg-success text-light' : '' }}"><select class="form-control w-100 {{ $order['id_order'] == $newOrderId ? 'bg-success text-light' : '' }}" name="newStatus">
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
