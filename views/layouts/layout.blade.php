<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description }}"
    <meta name="keywords" content="{{ $keywords }}"
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="shortcut icon" type="image/png" href="/public/img/favicon.ico">
	<script src="/public/js/jquery.min.js"></script>
    <script src="/public/js/bootstrap.min.js"></script>
    <script src="/public/js/showMore.js"></script>
    <script src="/public/js/addToBasket.js"></script>
    <script src="/public/js/selectBrand.js"></script>
    <script src="/public/js/showModalConfirmation.js"></script>
    <script>
        $(document).ready(function() {
            selectBrand();
        })
    </script>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-bottom d-flex justify-content-between">
                <a class="navbar-brand" href="/"><img src="/public/img/logo.jpg" alt="logo" class="logo"></a>
                <div class="w-100 container collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="col-3 navbar-nav mr-auto">
                        <li class="nav-item mr-3">
                            <a class="nav-link font-weight-bold {{ $layout['active'] == 'index' ? 'active' : 'text-info'}}" href="/">Главная<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link font-weight-bold {{ $layout['active'] == 'catalog' ? 'active' : 'text-info'}}" href="/phones">Каталог<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold {{ $layout['active'] == 'contacts' ? 'active' : 'text-info'}}" href="/contacts">Контакты<span class="sr-only"></span></a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0 col-5 d-flex justify-content-end" action="/search" method='post'>
                        <input class="form-control mr-sm-2 text-info" name="search" type="search" placeholder="Найти модель..." aria-label="Search">
                        <button class="btn btn-outline-info my-2 my-sm-0 font-weight-bold" type="submit">Поиск</button>
                    </form>
                    <ul class="col-1 navbar-nav ml-auto">
                        <li class="nav-item mr-3">
                            <a class="nav-link font-weight-bold d-flex {{ $layout['active'] == 'basket' ? 'active' : 'text-info'}}" href="/basket">
                            <img src="/public/img/basket.png" style="background-color: transparent" alt="Корзина"></img>
                            <span class="badge text-light badge-info float-right h-50 ml-1" id="basket">{{ $layout['user']['basket_size'] ?? 0 }}</span></a>
                        </li>
                    </ul>
                    @if (!isset($_SESSION['authed']))
                        <ul class="col-3 navbar-nav mr-auto text-right">
                            <li class="nav-item mr-3">
                                <a class="nav-link font-weight-bold {{ $layout['active'] == 'login' ? 'active' : 'text-info'}}" href="/login">Вход<span class="sr-only"></span></a>
                            </li>
                            <li class="nav-item mr-3">
                                <a class="nav-link font-weight-bold {{ $layout['active'] == 'reg' ? 'active' : 'text-info'}}" href="/registry">Регистрация<span class="sr-only"></span></a>
                            </li>
                        </ul>
                    @else
                        <ul class="col-3 navbar-nav mr-auto text-right">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle font-weight-bold text-info" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ $layout['user']['first_name'] ?? $layout['user']['login'] }}</a>
                                <div class="dropdown-menu text-left text-info">
                                @if ($layout['user']['id_role'] >= $layout['access']['AdminBrandController'])
                                    <span class="ml-4">{{ $layout['user']['name_role'] }}</span>
                                    <div class="dropdown-divider"></div>
                                @endif
                                @if ($layout['user']['id_role'] >= $layout['access']['AdminBrandController'])
                                    <a class="dropdown-item text-info" href="/brands">Бренды</a>
                                @endif
                                @if ($layout['user']['id_role'] >= $layout['access']['AdminModelController'])
                                    <a class="dropdown-item text-info" href="/tels">Модели</a>
                                @endif
                                @if ($layout['user']['id_role'] >= $layout['access']['AdminDiscountController'])
                                    <a class="dropdown-item text-info" href="/discounts">Скидки</a>
                                @endif
                                @if ($layout['user']['id_role'] >= $layout['access']['AdminOrderController'])
                                    <a class="dropdown-item text-info" href="/orders">Заказы</a>
                                @endif
                                @if ($layout['user']['id_role'] >= $layout['access']['AdminRoleController'])
                                    <a class="dropdown-item text-info" href="/roles">Роли</a>
                                @endif
                                @if ($layout['user']['id_role'] >= $layout['access']['AdminUserController'])
                                    <a class="dropdown-item text-info" href="/users">Пользователи</a>
                                @endif
                                    <a class="dropdown-item text-info" href="/cabinet">Кабинет</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-info" href="/logout">Выход</a>
                                </div>
                            </li>
                        </ul>
                    @endif
                </div>
            </nav>
        </div>
        <div class="col-12 text-center mx-auto conteiner">

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
