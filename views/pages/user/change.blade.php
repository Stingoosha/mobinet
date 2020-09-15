@extends('layouts.layout', ['title' => 'Кабинет', 'userData' => $userData])

@section('content')

    <div class="row">
        <div class="col-8 mx-auto text-left">
            <h1 class="display-1 text-info">Ваш кабинет</h1>
            <form class="col-6 text-left mx-auto" method="post">
                <label for="first_name" class="col-form-label">Ваше имя:</label><br>
                <input class="form-control" type="text" name="first_name" value="{{ $userData['first_name'] ?? '' }}"><br>
                <label for="last_name" class="col-form-label">Фамилия:</label><br>
                <input class="form-control" type="text" name="last_name" value="{{ $userData['last_name'] ?? '' }}"><br>
                <label for="email" class="col-form-label">Электронная почта:</label><br>
                <input class="form-control" type="email" name="email" value="{{ $userData['email'] ?? '' }}"><br>
                <label for="male" class="col-form-label">Пол:</label><br>
                <input class="form-check-input" type="radio" name="male" value="man" checked>М<br>
                <input class="form-check-input" type="radio" name="male" value="woman">Ж<br>
                <label for="birthday" class="col-form-label">День Рождения:</label><br>
                <input class="form-check-input text-center mx-auto" type="date" name="birthday" placeholder="ГГГГ-ММ-ДД" value="{{ $userData['birthday'] ?? '' }}"><br><br>
                <div class="btns text-center">
                    <input type="submit" class="btn btn-outline-success col-4" value="Сохранить">
                    <input type="reset" class="btn btn-outline-danger col-4" value="Очистить">
                </div>
            </form>
            <div class="btns text-center mt-3 col-6 mx-auto">
                <a href="/cabinet" class="mx-auto"><button class="btn btn-outline-warning px-5 col-4">Отмена</button></a>
            </div>
        </div>
    </div>

@endsection
