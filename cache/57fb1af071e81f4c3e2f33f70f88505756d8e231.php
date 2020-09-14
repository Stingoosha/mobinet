<div class="block_buy">
    <h3  class="description-title">Количество:</h3>
    <input type="text" id="phone_id" value="<?php echo e($phone['id']); ?>" hidden>
    <input type="number" id="amount_<?php echo e($phone['id']); ?>" value="<?php echo e($amount ?? '1'); ?>"><br>
    <input type="button" value="Купить" onclick="addToBasket(<?php echo e((int)$phone['id']); ?>)"><br>
    <span class="msg" style="color: orange; font-size: 20px" id="message_<?php echo e($phone['id']); ?>"></span>
</div>
<?php /**PATH D:\Sergey\Study\Web\Repositories\mobinet\views/partials/buy.blade.php ENDPATH**/ ?>