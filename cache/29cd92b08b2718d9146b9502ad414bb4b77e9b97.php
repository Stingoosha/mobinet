

<?php $__env->startSection('content'); ?>

    <h1 class="display-1 text-info">Наш каталог</h1>
    <div class="row">
        <div class="col-2 card border-info h-200">
            <h5 class="text-info">Бренды</h5>
            <div class="col-12 d-flex flex-column" id="brends">

                <?php $__currentLoopData = $brends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="form-check form-check-inline text-info">
                        <input class="form-check-input checkbox" type="checkbox" value="<?php echo e($brend['id_brend']); ?>">
                        <label class="form-check-label" for="<?php echo e($brend['id_brend']); ?>"><?php echo e($brend['name_brend']); ?></label>
                    </div>
                    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="btns text-center">
                        <a href="/phones"><button class="mx-auto btn btn-outline-info col-10 mb-3">Сбросить</button></a>
                    </div>

            </div>
        </div>
        <div class="col-10">
            <div class="row row-cols-1 row-cols-md-3" id="showMore-container">
                    
                <?php $__currentLoopData = $phones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
                    <div class="col-2 mb-3">
                        <div class="card-deck">
                            <div class="card border-info text-info mb-3 h-100">
                            <a class="link stretched-link" href="phones/<?php echo e($phone['id']); ?>"><img src="<?php echo e($pathImgSmall); ?><?php echo e($phone['photo'] ? $phone['photo'] : 'default.jpg'); ?>" class="card-img-top" alt="Мобила"></a>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo e($phone['name']); ?></h5>
                                <p class="card-text text-success font-weight-bold"><?php echo e($phone['price']); ?> &#8381;</p>
                            </div>
                            </div>
                        </div>
                    </div>
        
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </div>

    <?php if(!isset($_POST['search'])): ?>

        <div class="btns text-center" id="showMore-div">
            <button class="mx-auto btn btn-outline-info col-5" id="showMore-btn" onclick="showMore(<?= $phone['id'] ?>,<?= $total ?>)">Показать еще...</button>
        </div>

    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', ['title' => 'Каталог'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Sergey\Study\Web\Repositories\mobinet\views/pages/catalog.blade.php ENDPATH**/ ?>