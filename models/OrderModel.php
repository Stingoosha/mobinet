<?php

namespace models;

class OrderModel extends BaseModel
{
    protected $table = 'orders';

    public function allOrders($id)
    {
        return $this->query("SELECT * FROM $this->table WHERE user_id=:user_id", 'fetchAll', ['user_id' => $id]);
    }

    public function createOrder($params)
    {

        self::$db = $this->connect();

        try {
            self::$db->beginTransaction();

            // INSERT INTO orders (delivery_method, first_name, phone, email, discount_card, addr, mailing, comment, user_id, order_date, order_state) VALUES ( 'самовывоз', '', '977130799', '', '', 'Куйлюк-7-7-77', 'off', '', '131', NOW(), 'в процессе')
            $sql = "INSERT INTO orders (delivery_method, first_name, phone, email, discount_card, addr, mailing, comment, user_id, order_date, order_state) VALUES ( :delivery_method, :first_name, :phone, :email, :discount_card, :addr, :mailing, :comment, :user_id, NOW(), 'в процессе')";

            $query = self::$db->prepare($sql);
            $query->execute($params);
            $orderId = self::$db->lastInsertId();

            // UPDATE basket SET order_id=84 WHERE user_id=131 AND order_id IS NULL
            $sql = "UPDATE basket SET order_id=:order_id WHERE user_id=:user_id AND order_id IS NULL";

            $query = self::$db->prepare($sql);
            $query->execute(['order_id' => $orderId, 'user_id' => $params['user_id']]);

            // CREATE VIEW summ_calc AS SELECT basket.good_id, basket.order_id, basket.amount * goods.price as sum, basket.amount * goods.new_price as new_sum FROM basket INNER JOIN goods on basket.good_id=goods.id WHERE basket.order_id=84
            $sql = "CREATE VIEW summ_calc AS SELECT basket.good_id, basket.order_id, basket.amount * goods.price as sum, basket.amount * goods.new_price as new_sum FROM basket INNER JOIN goods on basket.good_id=goods.id WHERE basket.order_id=:order_id";

            $query = self::$db->prepare($sql);
            $query->execute(['order_id' => $orderId]);

            $orderSumm = $this->getOrderSum();
            // var_dump($orderSumm);

            // UPDATE orders SET order_price=62400 WHERE order_id=84
            $sql = "UPDATE orders SET order_price=:order_summ WHERE order_id=:order_id";

            $query = self::$db->prepare($sql);
            $query->execute(['order_summ' => $orderSumm, 'order_id' => $orderId]);

            // $query->rowCount()

            self::$db->commit();
            return true;

        } catch (Exception $e) {
            self::$db->rollBack();
            echo "Ошибка: " . $e->getMessage();
        }
    }

    public function getOrderSum()
    {
        $sql = "SELECT sum, new_sum FROM summ_calc";

        $res = $this->query($sql, 'fetchAll');

        $sumTotal = 0;

        foreach ($res as $val) {
            $sum = $val['new_sum'] ?? $val['sum'];
            $sumTotal += $sum;
        }

        return $sumTotal;
    }

    public function clearSum()
    {
        self::$db = $this->connect();

        $sql = "DROP VIEW IF EXISTS summ_calc";

        $query = self::$db->prepare($sql);
        $query->execute();
    }

}
