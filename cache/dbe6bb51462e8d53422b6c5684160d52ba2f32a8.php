<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo e($title); ?></title>
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
            <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-bottom d-flex justify-content-between">
                <a class="navbar-brand" href="/"><img src="../public/img/logo.jpg" alt="logo" class="logo"></a>
                <div class="w-100 container collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="col-3 navbar-nav mr-auto">
                        <li class="nav-item mr-3">
                            <a class="nav-link font-weight-bold <?php echo e($active == 'index' ? 'active' : 'text-info'); ?>" href="/">Главная<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link font-weight-bold <?php echo e($active == 'catalog' ? 'active' : 'text-info'); ?>" href="/phones">Каталог<span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold <?php echo e($active == 'contacts' ? 'active' : 'text-info'); ?>" href="/contacts">Контакты<span class="sr-only"></span></a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0 col-5 d-flex justify-content-end" action="#">
                        <input class="form-control mr-sm-2 text-info" name="search" type="search" placeholder="Найти модель..." aria-label="Search">
                        <button class="btn btn-outline-info my-2 my-sm-0 font-weight-bold" type="submit">Поиск</button>
                    </form>
                    <ul class="col-1 navbar-nav ml-auto">
                        <li class="nav-item mr-3">
                            <a class="nav-link font-weight-bold <?php echo e($active == 'basket' ? 'active' : 'text-info'); ?>" href="/basket">Корзина<span class="sr-only"></span></a>
                        </li>
                    </ul>
                    <?php if(!isset($_SESSION['userLogin'])): ?>
                        <ul class="col-3 navbar-nav mr-auto text-right">
                            <li class="nav-item mr-3">
                                <a class="nav-link font-weight-bold <?php echo e($active == 'auth' ? 'active' : 'text-info'); ?>" href="/auth">Вход<span class="sr-only"></span></a>
                            </li>
                            <li class="nav-item mr-3">
                                <a class="nav-link font-weight-bold <?php echo e($active == 'reg' ? 'active' : 'text-info'); ?>" href="/registry">Регистрация<span class="sr-only"></span></a>
                            </li>
                        </ul>
                    <?php else: ?>
                        <ul class="col-3 navbar-nav mr-auto text-right">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle font-weight-bold text-info" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo e($_SESSION['userLogin']); ?></a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Cabinet</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
        <div class="col-12 text-center mx-auto conteiner">

            <?php if(isset($_SESSION['flash'])): ?>
                <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                    <?php echo e($_SESSION['flash']); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php unset($_SESSION['flash']); ?>

            <?php echo $__env->yieldContent('content'); ?>

        </div>
        <div class="col-12 mt-3 footer">
            <p class="col-12 mx-auto rounded-top bg-info footer-text">Все права защищены &copy; <?php echo e(date('Y')); ?></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\Study\PHP\Projects\repositories\mobinet\views/layouts/layout.blade.php ENDPATH**/ ?>