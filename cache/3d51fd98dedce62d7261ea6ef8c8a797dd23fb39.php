

<?php $__env->startSection('content'); ?>

    <h1 class="display-1 text-info"><?php echo e($phone['name']); ?></h1>
    <div class="row">
        <div class="col-6 mb-3 mx-auto">
            <div class="card-deck text-center">
                <div class="card border-info text-info mb-3">
                    <img class="w-25 card-img-top" src="../<?php echo e($pathImgLarge); ?><?php echo e($phone['photo'] ? $phone['photo'] : 'default.jpg'); ?>" alt="Мобила">
                    <div class="card-body">
                    <h5 class="card-content"><?php echo e($phone['short_desc']); ?></h5>
                    <?php if($phone['new_price']): ?>
                        <p class="card-text text-success font-weight-bold">Цена:&emsp;<del><?php echo e($phone['price']); ?> &#8381;</del>&emsp;<?php echo e($phone['new_price']); ?> &#8381;</p>
                    <?php else: ?>
                        <p class="card-text text-success font-weight-bold">Цена: <?php echo e($phone['price']); ?> ₽</p>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <?php echo $__env->make('partials/buy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <a href="/phones" class="col-2 mx-auto"><button class="btn btn-outline-info px-5">В каталог</button></a>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', ['title' => $phone['name']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Sergey\Study\Web\Repositories\mobinet\views/pages/show.blade.php ENDPATH**/ ?>