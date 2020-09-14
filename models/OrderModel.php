<?php
namespace models;

/**
 * Модель заказа
 */
class OrderModel extends BaseModel
{
    /**
     * @var string $table Наименование таблицы заказов
     */
    protected $table = 'orders';

    /**
     * Функция вывода всех заказов пользователя по его id
     * @var int $id Идентификацционный номер пользователя id
     * @return array
     */
    public function allOrders(int $id) :array
    {
        return $this->query("SELECT * FROM $this->table WHERE user_id=:user_id", 'fetchAll', ['user_id' => $id]);
    }

    /**
     * Функция формирования заказа с помощью транзакции
     * @var array $params Массив данных заказа
     */
    public function createOrder(array $params)
    {

        // var_dump($params);die;
        self::$db = $this->connect(); // подключение к БД

        try {
            self::$db->beginTransaction(); // начало транзакции

            $orderId = $this->insert($params); // сохранение нового заказа и получение его id
            // var_dump($orderId);die;

            // обновление в корзине order_id по всем моделям, присутствующим в заказе
            // UPDATE basket SET order_id=84 WHERE user_id=131 AND order_id IS NULL
            $sql = "UPDATE basket SET order_id=:order_id WHERE user_id=:user_id AND order_id IS NULL";

            $query = self::$db->prepare($sql);
            $query->execute(['order_id' => $orderId, 'user_id' => $params['user_id']]);

            // создание промежуточной таблицы для расчета стоимости заказа
            // CREATE VIEW summ_calc AS SELECT basket.good_id, basket.order_id, basket.amount * goods.price as sum, basket.amount * goods.new_price as new_sum FROM basket INNER JOIN goods on basket.good_id=goods.id WHERE basket.order_id=84
            $sql = "CREATE VIEW summ_calc AS SELECT basket.good_id, basket.order_id, basket.amount * goods.price as sum, basket.amount * goods.new_price as new_sum FROM basket INNER JOIN goods on basket.good_id=goods.id WHERE basket.order_id=:order_id";

            $query = self::$db->prepare($sql);
            $query->execute(['order_id' => $orderId]);

            $orderSumm = $this->getOrderSum(); // получение стоимости заказа
            // var_dump($orderSumm);

            // указание стоимости заказа в таблице заказов по его id
            // UPDATE orders SET order_price=62400 WHERE order_id=84
            $sql = "UPDATE orders SET order_price=:order_summ WHERE order_id=:order_id";

            $query = self::$db->prepare($sql);
            $query->execute(['order_summ' => $orderSumm, 'order_id' => $orderId]);

            // $query->rowCount()

            self::$db->commit(); // подтверждение успешного завершения транзакции
            return true;

        } catch (\Exception $e) {
            self::$db->rollBack();
            echo "Ошибка: " . $e->getMessage();
        }
    }

    /**
     * Функция подсчета стоимости заказа
     * @return ?int Возвращает либо null, либо int
     */
    public function getOrderSum() :?int
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

    /**
     * Функция удаления промежуточной таблицы, служащей для расчета стоимости заказа
     * @return void
     */
    public function clearSum() :void
    {
        self::$db = $this->connect();

        $sql = "DROP VIEW IF EXISTS summ_calc";

        $query = self::$db->prepare($sql);
        $query->execute();
    }

}
