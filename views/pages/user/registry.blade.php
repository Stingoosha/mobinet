@extends('layouts.layout', ['title' => 'Регистрация'])

@section('content')

    <div class="row">
        <div class="col-6 mx-auto">
            <h1 class="display-1 text-info">Регистрация</h1>
            <form class="col-6 text-left mx-auto" method="post">
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input type="text" name="login" class="form-control" placeholder="Введите логин" value="{{ $login ?? '' }}" required>
                </div>
                <div class="form-group">
                    <label for="pass">Пароль</label>
                    <input type="password" name="pass" class="form-control" placeholder="Введите пароль" value="{{ $pass ?? '' }}" required>
                </div>
                <div class="btns text-center">
                    <button type="submit" class="btn btn-outline-info col-10">Зарегистрироваться</button>
                </div>
            </form>
        </div>
    </div>

@endsection
