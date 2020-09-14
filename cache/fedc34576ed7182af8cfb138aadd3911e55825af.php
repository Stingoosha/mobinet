

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-8 mx-auto text-left">
            <h1 class="display-1 text-info">Ваш кабинет</h1>
            <h4 class="display-4 text-success font-weight-bold">Здравствуйте, <?php echo e($userData['first_name'] ?? $_SESSION['userLogin']); ?>!</h4>
            <h4 class="display-4 text-info">Ваши персональные данные:</h4>
            <h4 class="display-4 text-danger">Имя:<span class="badge badge-success ml-3"><?php echo e($userData['first_name']); ?></span></h4>
            <h4 class="display-4 text-warning">Фамилия:<span class="badge badge-info ml-3"><?php echo e($userData['last_name']); ?></span></h4>
            <h4 class="display-4 text-success">Электронная почта:<span class="badge badge-danger ml-3"><?php echo e($userData['email']); ?></span></h4>
            <h4 class="display-4 text-warning">Пол:<span class="badge badge-info ml-3"><?php echo e($userData['male']); ?></span></h4>
            <h4 class="display-4 text-danger">День рождения:<span class="badge badge-success ml-3"><?php echo e($userData['birthday']); ?></span></h4>
            <div class="btns text-center">
                <a href="/cabinet/change"><button class="btn btn-outline-info col-8 mx-auto mt-3">Изменить</button></a>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', ['title' => 'Кабинет'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Sergey\Study\Web\Repositories\mobinet\views/pages/cabinet.blade.php ENDPATH**/ ?>