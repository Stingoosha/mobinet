@extends('layouts.layout', ['title' => 'Кабинет', 'layout' => $layout])

@section('content')

    <div class="row">
        <div class="col-8 mx-auto text-left">
            <h1 class="display-1 text-info">Ваш кабинет</h1>
            <h4 class="display-4 text-success font-weight-bold">Здравствуйте, {{ $layout['user']['first_name'] ?? $layout['user']['login'] }}!</h4>
            <h4 class="display-4 text-info">Ваши персональные данные:</h4>
            <h4 class="display-4 text-danger">Имя:<span class="badge badge-success ml-3">{{ $layout['user']['first_name'] }}</span></h4>
            <h4 class="display-4 text-warning">Фамилия:<span class="badge badge-info ml-3">{{ $layout['user']['last_name'] }}</span></h4>
            <h4 class="display-4 text-success">Электронная почта:<span class="badge badge-danger ml-3">{{ $layout['user']['email'] }}</span></h4>
            <h4 class="display-4 text-warning">Пол:<span class="badge badge-info ml-3">{{ $layout['user']['male'] }}</span></h4>
            <h4 class="display-4 text-danger">День рождения:<span class="badge badge-success ml-3">{{ $layout['user']['birthday'] }}</span></h4>
            <div class="btns text-center">
                <a href="/cabinet/edit"><button class="btn btn-outline-info col-8 mx-auto mt-3">Изменить</button></a>
            </div>
        </div>
    </div>

@endsection
