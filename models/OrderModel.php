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
            $sql = "UPDATE basket SET id_order=:id_order WHERE id_user=:id_user AND id_order IS NULL";

            $query = self::$db->prepare($sql);
            $query->execute(['id_order' => $orderId, 'id_user' => $params['id_user']]);

            // создание промежуточной таблицы для расчета стоимости заказа
            $sql = "CREATE VIEW summ_calc AS SELECT basket.id_good, basket.id_order, basket.amount * goods.price_good as sum, basket.amount * goods.new_price as new_sum FROM basket,goods WHERE basket.id_good=goods.id_good AND basket.id_order=:id_order";

            $query = self::$db->prepare($sql);
            $query->execute(['id_order' => $orderId]);

            $orderSumm = $this->getOrderSum(); // получение стоимости заказа
            // var_dump($orderSumm);die;

            // указание стоимости заказа в таблице заказов по его id
            $sql = "UPDATE orders SET price_order=:price_order WHERE id_order=:id_order";

            $query = self::$db->prepare($sql);
            $query->execute(['price_order' => $orderSumm, 'id_order' => $orderId]);

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
            $sum = empty((int)$val['new_sum']) ? $val['sum'] : $val['new_sum'];
            $sumTotal += $sum;
        }
        // var_dump($sumTotal);die;
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
