@extends('layouts.layout', ['title' => 'Данные модели ' . $phone['name'], 'layout' => $layout])

@section('content')

    <h2 class="display-2 text-info">Данные модели {{ $phone['name'] }}</h2>
    <div class="row">
        <div class="col-7 mx-auto">
            <div class="table-responsive">
            <form enctype="multipart/form-data" action="/tels/{{ $phone['id'] }}/save" method="post">
                <table class="table text-info">
                    <tr class="bg-info">
                        <th>Наименование</th>
                        <th>Значение</th>
                    </tr>
                    <tr>
                        <td>Наименование модели</td>
                        <td>{{ $phone['name'] }}</td>
                    </tr>
                    <tr>
                        <td>Наименование бренда</td>
                        <td>{{ $phone['name_brand'] }}</td>
                    </tr>
                    <tr>
                        <td>Стоимость</td>
                        <td>{{ $phone['price'] }} &#8381;</td>
                    </tr>
                    <tr>
                        <td>Новая цена</td>
                        <td>{{ $phone['new_price'] ?? '0' }} &#8381;</td>
                    </tr>
                    <tr>
                        <td>Фотография</td>
                        <td class="d-flex border-0 justify-content-around"><a href="/phones/{{ $phone['id'] }}"><img src="../{{ $pathImgSmall }}{{ $phone['photo'] ?? 'default.jpg' }}"></img></a><input type="file" class="btn btn-outline-info h-100 my-auto" name="newPhonePhoto"></td>
                    </tr>
                    <tr>
                        <td>Описание</td>
                        <td><div class="form-group h-auto"><textarea class="form-control" name="newPhoneDesc" placeholder="Описание модели" rows="5" cols="50">{{ $phone['short_desc'] }}</textarea></div></td>
                    </tr>
                </table>
                </div>
                <button type="submit"  class="btn btn-outline-success px-5 col-5 mr-3">Изменить</button>
            </form>
            <a href="/tels" class="mx-auto"><button class="btn btn-outline-info px-5 col-5">К моделям</button></a>
        </div>
    </div>

@endsection
