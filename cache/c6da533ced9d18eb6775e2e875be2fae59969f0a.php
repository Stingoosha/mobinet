

<?php $__env->startSection('content'); ?>

    <p style="color: red"><?php echo e($message ?? ''); ?></p>
    <div class="row">
        <div class="col-12 mx-auto">
            <?php if($orders): ?>
            <div class="orders-info">
                <h1 class="display-1 text-info">Ваши заказы</h1>
                <div class="table-responsive">
                    <table class="table text-info">
                        <tr class="bg-info">
                            <th>Время заказа</th>
                            <th>Стоимость заказа</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Дисконтная карта</th>
                            <th>Способ доставки</th>
                            <th>Адрес</th>
                            <th>Комментарий</th>
                            <th>Состояние</th>
                        </tr>
                    <?php if(!empty($orders)): ?>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($order['order_date']); ?></td>
                                <td><?php echo e($order['order_price']); ?> &#8381;</td>
                                <td><?php echo e($order['first_name']); ?></td>
                                <td><?php echo e($order['phone']); ?></td>
                                <td><?php echo e($order['discount_card']); ?></td>
                                <td><?php echo e($order['delivery_method']); ?></td>
                                <td><?php echo e($order['addr']); ?></td>
                                <td><?php echo e($order['comment']); ?></td>
                                <td><?php echo e($order['order_state']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endif; ?>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            <div class="basket-info">
                <h1 class="display-1 text-info">Ваша корзина</h1>
                <div class="table-responsive">
                    <table class="table text-info">
                        <tr class="bg-info">
                            <th>Наименование</th>
                            <th>Стоимость</th>
                            <th>Количество</th>
                            <th>Сумма</th>
                            <th>Удалить</th>
                        </tr>
                        <?php if(!empty($phones)): ?>
                        <?php $__currentLoopData = $phones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $phonePrice = $phone['new_price'] ?? $phone['price'];
                                $summ += ($phone['price'] * $phone['amount']);
                                $summFinal += ($phonePrice * $phone['amount']);
                            ?>
                            <tr>
                                <td><a href="/phones/<?php echo e($phone['good_id']); ?>"><img src="<?php echo e($pathImgSmall); ?><?php echo e($phone['photo'] ? $phone['photo'] : 'default.jpg'); ?>"><?php echo e($phone['name']); ?></img></a></td>
                                <td>
                                    <?php if($phone['new_price']): ?>
                                        <del><?php echo e($phone['price']); ?> &#8381;</del>&emsp;<?php echo e($phone['new_price']); ?> &#8381;
                                    <?php else: ?>
                                        <?php echo e($phone['price']); ?> &#8381;
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($phone['amount']); ?></td>
                                <td>
                                    <?php if($phone['new_price']): ?>
                                        <del><?=$phone['price'] * $phone['amount']?> &#8381;</del>&emsp;<?=$phone['new_price'] * $phone['amount']?> &#8381;
                                    <?php else: ?>
                                        <?php echo e($phone['price'] * $phone['amount']); ?> &#8381;
                                    <?php endif; ?>
                                </td>
                                <td><a class="remove" href="/basket/<?php echo e($phone['good_id']); ?>/remove">&#10060;</a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <?php if(!empty($phones)): ?>
                <p class="total lead">ИТОГО:&emsp;
                    <?php if($summFinal !== $summ): ?>
                        <del><?=$summ?> &#8381;</del>&emsp;<?php echo e($summFinal); ?> &#8381;
                    <?php else: ?>
                        <?php echo e($summ); ?> &#8381;
                    <?php endif; ?>
                </p>
                <div class="btns text-center">
                    <a href="/order" class="mx-auto"><button class="btn btn-outline-success px-5 col-5">Оформить заказ</button></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', ['title' => 'Корзина'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Sergey\Study\Web\Repositories\mobinet\views/pages/basket.blade.php ENDPATH**/ ?>