@extends('layouts.layout', ['title' => 'Контакты'])

@section('content')

    <div class="row">
        <div class="col-6 text-left mx-auto">
            <h1 class="display-1 text-info">Наши контакты</h1>
            <h4 class="display-4">Адрес</h4>
            <ul class="list-unstyled">
                <li><i>Контактный номер:</i> +79009090909, добавочный 999</li>
                <li><i>Адрес:</i> г. Москва, Новокузнецкий переулок, дом 18А</li>
                <li><i>Email:</i> mobinet@mail.ru</li>
                <li><i>Ориентиры:</i> станция метро &quot;Комсомольская&quot;</li>
            </ul>
            <div class="map">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Af0a580086a33e883bb94e1585ffee36a820f491ca4358023dcd487906b188797&amp;width=500&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
            </div>
            <h1 class="display-1 text-info">Напишите нам</h1>
            <form action="#">
                <fieldset>
                        <input class="form-control" type="text" placeholder="Имя*" required><br>
                        <input class="form-control" type="email" placeholder="Email*" required><br>
                        <input class="form-control" type="text" placeholder="Тема*" required><br>
                        <textarea class="form-control form-control-lg" type="textarea" placeholder="Текст письма" size="100"></textarea><br>
                        <p class="lead">Хобби:</p>
                        <input class="form-check-input" type="checkbox">IT-технологии<br>
                        <input class="form-check-input" type="checkbox">Спорт<br>
                        <input class="form-check-input" type="checkbox">Музыка<br>
                        <input class="form-check-input" type="checkbox">Иностраные языки<br>
                        <input class="form-check-input" type="checkbox">Фильмы<br>
                        <input class="form-check-input" type="checkbox">Игры<br>
                        <input class="form-check-input" type="checkbox">Эзотерика<br>
                        <p class="lead">* - поля, обязательные для заполнения</p>
                        <div class="btns text-center">
                            <input type="submit" class="btn btn-outline-success col-5" value="Отправить">
                            <input type="reset" class="btn btn-outline-danger col-5" value="Очистить">
                        </div>
                </fieldset>
            </form>
        </div>
    </div>




@endsection
