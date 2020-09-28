@extends('layouts/layout', ['title' => 'Заказ', 'layout' => $layout])

@section('content')

    <div class="row">
        <div class="col-10 mx-auto text-left text-info">
            <h1 class="display-1 text-info">Ваш заказ</h1>
            <div class="table-responsive">
                <table class="table text-info">
                    <tr class="bg-info">
                        <th>Наименование</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                    </tr>
                    @foreach ($phones as $phone)
                        <?php
                            $phone['price_good'] = empty((int)($phone['new_price'])) ? $phone['price_good'] : $phone['new_price'];
                            $summ += ($phone['price_good'] * $phone['amount']);
                        ?>
                        <tr>
                            <td><a href="/phones/{{ $phone['id_good'] }}"><img src="{{ $pathImgSmall }}{{ $phone['photo'] ? $phone['photo'] : 'default.jpg' }}">{{ $phone['name_good'] }}</img></a></td>
                            <td>{{ $phone['amount'] }}</td>
                            <td>{{ $phone['price_good'] * $phone['amount'] }} &#8381;</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <p class="total lead">ИТОГО: {{ $summ }} &#8381;</p>
            <div class="col-6 mx-auto text-left text-info">
                <form action="/order/save" method="POST">
                    <label for="delivery_method" class="col-form-label">Способ доставки:</label><br>
                    <input type="radio" name="delivery_method" value="самовывоз" checked>Самовывоз<br>
                    <input type="radio" name="delivery_method" value="доставка">Доставка<br>
                    <label for="first_name" class="col-form-label">Ваше имя:</label><br>
                    <input class="form-control" type="text" name="first_name" value="{{ $user['first_name'] ?? '' }}"><br>
                    <label for="phone" class="col-form-label">Номер телефона:</label><br>
                    <input class="form-control" type="text" name="phone" value="{{ $user['phone'] ?? '' }}" required><br>
                    <label for="email" class="col-form-label">Электронная почта:</label><br>
                    <input class="form-control" type="text" name="email" value="{{ $user['email'] ?? '' }}"><br>
                    <input class="form-check-input" type="checkbox" name="mailing">
                    <label for="mailing" class="col-form-label">Получать спец предложения</label><br>
                    <label for="discount_card" class="col-form-label">Дисконтная карта:</label><br>
                    <input class="form-control" type="text" name="discount_card" value="{{ $user['discount_card'] ?? '' }}"><br>
                    <label for="addresses" class="col-form-label">Адрес:</label><br>
                    <input class="form-control" type="text" name="addresses" value="{{ $user['addresses'] ?? '' }}" required><br>
                    <label for="comments" class="col-form-label">Комментарий:</label><br>
                    <textarea class="form-control form-control-lg" type="textarea" placeholder="Ваш комментарий" size="300" name="comments">{{ $user['comments'] ?? '' }}</textarea><br><br>
                    <div class="btns text-center">
                        <input type="submit" class="btn btn-outline-success col-4" value="Сохранить">
                        <input type="reset" class="btn btn-outline-danger col-4" value="Очистить">
                    </div>
                </form>
            </div>
            <div class="btns text-center mt-3 col-6 mx-auto">
                <a href="/basket" class="mx-auto"><button class="btn btn-outline-warning px-5 col-4">Отмена</button></a>
            </div>
        </div>
    </div>

@endsection
