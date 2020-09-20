@extends('layouts.layout', ['title' => 'Пользователь ID-' . $user['id'], 'layout' => $layout])

@section('content')

    <h1 class="display-1 text-info">Данные пользователя ID-{{ $user['id'] }}</h1>
    <div class="row">
        <div class="col-7 mx-auto">
            <div class="table-responsive">
            <table class="table text-info">
                <tr class="bg-info">
                    <th>Наименование</th>
                    <th>Значение</th>
                </tr>
                <tr>
                    <td>ID пользователя</td>
                    <td>{{ $user['id'] }}</td>
                </tr>
                <tr>
                    <td>Логин</td>
                    <td>{{ $user['login'] }}</td>
                </tr>
                <tr>
                    <td>Пароль</td>
                    <td>{{ $user['pass'] }}</td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td>{{ $user['first_name'] }}</td>
                </tr>
                <tr>
                    <td>Фамилия</td>
                    <td>{{ $user['last_name'] }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $user['email'] }}</td>
                </tr>
                <tr>
                    <td>Пол</td>
                    <td>{{ $user['male'] }}</td>
                </tr>
                <tr>
                    <td>День рождения</td>
                    <td>{{ $user['birthday'] }}</td>
                </tr>
                <tr>
                    <td>Роль</td>
                    <td>{{ $roleName }}</td>
                </tr>
            </table>
            </div>
            <a class="btn btn-ouline-info col-5" href="/users"><button class="btn btn-outline-info px-5 col-8">К пользователям</button></a>
        </div>
    </div>

@endsection
