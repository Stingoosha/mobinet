<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="shortcut icon" href="/public/img/favicon.ico">
	<script src="../public/js/jquery.min.js"></script>
    <script src="../public/js/bootstrap.min.js"></script>
    <script src="../public/js/getphonesdata.js"></script>
    <script src="../public/js/addToBasket.js"></script>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-bottom">
                <a class="navbar-brand" href="/"><img src="../public/img/logo.jpg" alt="logo" class="logo"></a>
                <div class="w-100 container collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="col-3 navbar-nav mr-auto">
                        <li class="nav-item mr-3">
                            <a class="nav-link font-weight-bold {{ $active == 'index' ? 'active' : 'text-info'}}" href="/">Главная <span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link font-weight-bold {{ $active == 'catalog' ? 'active' : 'text-info'}}" href="/phones">Каталог <span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold {{ $active == 'contacts' ? 'active' : 'text-info'}}" href="/contacts">Контакты <span class="sr-only"></span></a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0 mr-5" action="#">
                    <input class="form-control mr-sm-2 text-info" name="search" type="search" placeholder="Найти модель..." aria-label="Search">
                    <button class="btn btn-outline-info my-2 my-sm-0 font-weight-bold" type="submit">Поиск</button>
                    </form>
                    <ul class="col-3 navbar-nav ml-auto">
                        <li class="nav-item mr-3">
                            <a class="nav-link font-weight-bold {{ $active == 'basket' ? 'active' : 'text-info'}}" href="/basket">Корзина <span class="sr-only"></span></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="conteiner text-center mx-auto">

            @if (isset($_SESSION['flash']))
                <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                    {{ $_SESSION['flash'] }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <?php unset($_SESSION['flash']); ?>

            @yield('content')

        </div>
        <div class="col-12 mt-3 footer">
            <p class="col-12 mx-auto rounded-top bg-info footer-text">Все права защищены &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
