

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-6 mx-auto">
            <h1 class="display-1 text-info">Авторизация</h1>
            <form class="col-6 text-left mx-auto" method="post">
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input type="text" name="login" class="form-control p-3 text-black-50" placeholder="Введите логин" value="<?php echo e($login ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="pass">Пароль</label>
                    <input type="password" name="pass" class="form-control" placeholder="Введите пароль">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="remember" class="form-check-input">
                    <label class="form-check-label" for="remember">Запомнить</label>
                </div>
                <div class="btns text-center">
                    <button type="submit" class="btn btn-outline-info col-10">Войти</button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', ['title' => 'Авторизация'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Sergey\Study\Web\Repositories\mobinet\views/pages/login.blade.php ENDPATH**/ ?>