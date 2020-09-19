@extends('layouts.layout', ['title' => 'Авторизация', 'userData' => $userData])

@section('content')

    <div class="row">
        <div class="col-6 mx-auto">
            <h1 class="display-1 text-info">Авторизация</h1>
            <form class="col-6 text-left mx-auto" method="post">
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input type="text" name="login" class="form-control p-3 text-black-50" placeholder="Введите логин" value="{{ $login ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="pass">Пароль</label>
                    <input type="password" name="pass" class="form-control" placeholder="Введите пароль">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="remember" class="form-check-input">
                    <label class="form-check-label" for="remember">Запомнить на год</label>
                </div>
                <div class="btns text-center">
                    <button type="submit" class="btn btn-outline-info col-10">Войти</button>
                </div>
            </form>
        </div>
    </div>

@endsection
