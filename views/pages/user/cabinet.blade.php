@extends('layouts.layout', ['title' => 'Кабинет', 'userData' => $userData])

@section('content')

    <div class="row">
        <div class="col-8 mx-auto text-left">
            <h1 class="display-1 text-info">Ваш кабинет</h1>
            <h4 class="display-4 text-success font-weight-bold">Здравствуйте, {{ $userData['first_name'] ?? $userData['login'] }}!</h4>
            <h4 class="display-4 text-info">Ваши персональные данные:</h4>
            <h4 class="display-4 text-danger">Имя:<span class="badge badge-success ml-3">{{ $userData['first_name'] }}</span></h4>
            <h4 class="display-4 text-warning">Фамилия:<span class="badge badge-info ml-3">{{ $userData['last_name'] }}</span></h4>
            <h4 class="display-4 text-success">Электронная почта:<span class="badge badge-danger ml-3">{{ $userData['email'] }}</span></h4>
            <h4 class="display-4 text-warning">Пол:<span class="badge badge-info ml-3">{{ $userData['male'] }}</span></h4>
            <h4 class="display-4 text-danger">День рождения:<span class="badge badge-success ml-3">{{ $userData['birthday'] }}</span></h4>
            <div class="btns text-center">
                <a href="/cabinet/change"><button class="btn btn-outline-info col-8 mx-auto mt-3">Изменить</button></a>
            </div>
        </div>
    </div>

@endsection
