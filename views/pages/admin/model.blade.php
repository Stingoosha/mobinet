@extends('layouts.layout', ['title' => 'Данные модели ' . $phone['name_good'], 'layout' => $layout])

@section('content')

    <h3 class="display-3 text-info">Данные модели "{{ $phone['name_good'] }}"</h3>
    <div class="row">
        <div class="col-7 mx-auto">
            <div class="table-responsive">
            <form enctype="multipart/form-data" action="/tels/{{ $phone['id_good'] }}/save" method="post">
                <table class="table text-info">
                    <tr class="bg-info">
                        <th>Наименование</th>
                        <th>Значение</th>
                    </tr>
                    <tr>
                        <td>Наименование модели</td>
                        <td>{{ $phone['name_good'] }}</td>
                    </tr>
                    <tr>
                        <td>Год выпуска</td>
                        <td><input type="text" class="form-control text-info text-center" name="year" value="{{ $params['year'] ?? '' }}"></td>
                    </tr>
                    <tr>
                        <td>Стандарт</td>
                        <td><input type="text" class="form-control text-info text-center" name="standart" value="{{ $params['standart'] ?? '' }}"></td>
                    </tr>
                    <tr>
                        <td>Операционная система</td>
                        <td><input type="text" class="form-control text-info text-center" name="os" value="{{ $params['os'] ?? '' }}"></td>
                    </tr>
                    <tr>
                        <td>Процессор</td>
                        <td><input type="text" class="form-control text-info text-center" name="proc" value="{{ $params['proc'] ?? '' }}"></td>
                    </tr>
                    <tr>
                        <td>Количество SIM-карт</td>
                        <td><input type="text" class="form-control text-info text-center" name="sim" value="{{ $params['sim'] ?? '' }}"></td>
                    </tr>
                    <tr>
                        <td>Диагональ экрана</td>
                        <td><input type="text" class="form-control text-info text-center" name="display" value="{{ $params['display'] ?? '' }}"></td>
                    </tr>
                    <tr>
                        <td>Камера</td>
                        <td><input type="text" class="form-control text-info text-center" name="camera" value="{{ $params['camera'] ?? '' }}"></td>
                    </tr>
                    <tr>
                        <td>Объем оперативной памяти</td>
                        <td><input type="text" class="form-control text-info text-center" name="ram" value="{{ $params['ram'] ?? '' }}"></td>
                    </tr>
                    <tr>
                        <td>Объем встроенной памяти</td>
                        <td><input type="text" class="form-control text-info text-center" name="rom" value="{{ $params['rom'] ?? '' }}"></td>
                    </tr>
                    <tr>
                        <td>Емкость аккумулятора</td>
                        <td><input type="text" class="form-control text-info text-center" name="battery" value="{{ $params['battery'] ?? '' }}"></td>
                    </tr>
                    <tr>
                        <td>Фотография</td>
                        <td class="d-flex border-0 justify-content-around"><a href="/phones/{{ $phone['id_good'] }}"><img src="../{{ $pathImgSmall }}{{ $phone['photo'] ?? 'default.jpg' }}"></img></a><input type="file" class="btn btn-outline-info h-100 my-auto" name="newPhonePhoto"></td>
                    </tr>
                    <tr>
                        <td>Описание</td>
                        <td><div class="form-group h-auto"><textarea class="form-control text-info text-center" name="newPhoneDesc" placeholder="Описание модели" rows="5" cols="50">{{ $phone['description'] }}</textarea></div></td>
                    </tr>
                </table>
                </div>
                <button type="submit"  class="btn btn-outline-success px-5 col-5 mr-3">Изменить</button>
            </form>
            <a href="/tels" class="mx-auto"><button class="btn btn-outline-info px-5 col-5">К моделям</button></a>
        </div>
    </div>

@endsection
