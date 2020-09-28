<?php
namespace models;

/**
 * Модель корзины
 */
class BasketModel extends BaseModel
{
    /**
     * @var string $table Наименование таблицы корзины
     */
    protected $table = 'basket';

    /**
     * Функция проверки, были ли раннее добавлены такие же модели good_id этим пользователем user_id
     * @var array $params Массив с user_id и good_id
     * @return Может возвращать либо bool, либо array
     */
    public function isPhoneExists(array $params)
    {
        return $this->query("SELECT * FROM $this->table WHERE id_user=:id_user AND id_good=:id_good AND id_order IS NULL", 'fetch', $params);
    }

    /**
     * Функция обновления количества amount ранне добавленного товара при новом заказе одним и тем же пользователем по id корзины
     * @var array $params Массив с id модели и amount добавляемого количества
     * @var int
     */
    public function updateBasket(array $params) :int
    {
        return $this->query("UPDATE basket SET amount = amount + :amount WHERE id_user=:id_user", 'rowCount', $params);
    }

    /**
     * Функция вывода всех еще не заказанных товаров из корзины пользователя user_id
     * @var int $id Идентификацционный номер пользователя id
     * @return array
     */
    public function allFromBasket(int $id) :array
    {
        return $this->selfJoin('goods.id_good, photo, name_good, price_good, new_price, amount, id_basket', 'goods, basket', 'goods.id_good=basket.id_good AND basket.id_user=' . $id . ' AND basket.id_order IS NULL');
    }

    /**
     * Функция подсчета количества моделей в корзине пользователя
     * @var int $id Идентификацционный номер пользователя id
     * @return ?int
     */
    public function getBasketSize(int $id) :?int
    {
        $basketSize = 0;
        $basket = $this->allFromBasket((int)$_SESSION['userId']);

        if ($basket) {
            foreach ($basket as $model) {
                $basketSize += $model['amount'];
            }
        }
        return $basketSize;
    }
}
