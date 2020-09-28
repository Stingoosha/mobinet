@extends('layouts.layout', ['title' => 'Данные скидки ' . $discount['name_discount'], 'layout' => $layout])

@section('content')

    <h3 class="display-3 text-info">Cкидка {{ $discount['percent'] }}% "{{ $discount['name_discount'] }}"<br> создана {{ $discount['created_at'] }}</h3>
    <div class="row">
        <div class="col-10 mx-auto">
            <div class="table-responsive">
                <form action="/discounts/{{ $discount['id_discount'] }}/save" method="post">
                    <table class="table text-info">
                        <tr>
                            <th>
                                <input type="button" class="btn btn-outline-success col mb-3" value="Выделить все" onclick="check('chkbx', 1)">
                                <input type="button" class="btn btn-outline-danger col" value="Снять выделение" onclick="check('chkbx', 0)">
                            </th>
                            <th>ID модели</th>
                            <th>Наименование модели</th>
                            <th>Стоимость</th>
                            <th>Стоимость со скидкой</th>
                        </tr>
                        @if (!empty($phones))
                            @foreach ($phones as $phone)
                            <tr>
                                <td>
                                    <input type="checkbox" class="chkbx" name="phoneIds[]" value="{{ $phone['id_good'] }}" <?=in_array($phone['id_good'], $phoneIds) ? 'checked' : ''?>>
                                </td>
                                <td>{{ $phone['id_good'] }}</td>
                                <td>{{ $phone['name_good'] }}</td>
                                <td>{{ $phone['price_good'] }}</td>
                                <td>{{ $phone['new_price'] }}</td>
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
                    <button type="submit"  class="btn btn-outline-success px-5 col-5 mr-3">Изменить</button>
                </form>
                <a href="/discounts" class="mx-auto"><button class="btn btn-outline-info px-5 col-5">К скидкам</button></a>
        </div>
    </div>
    <script type="text/javascript">
    function check(className, flag) {
        x = document.querySelectorAll('.' + className);
        if (flag=="1") {
            for (i=0; i<x.length; i++) {
                if (x[i].type=="checkbox") x[i].checked=true;
            }
        }
        else {
            for (i=0; i<x.length; i++) {
                if (x[i].type=="checkbox") x[i].checked=false;
            }
        }
    }
    </script>

@endsection
