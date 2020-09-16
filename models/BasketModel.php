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
        return $this->query("SELECT * FROM $this->table WHERE user_id=:user_id AND good_id=:good_id AND order_id IS NULL", 'fetch', $params);
    }

    /**
     * Функция обновления количества amount ранне добавленного товара при новом заказе одним и тем же пользователем по id корзины
     * @var array $params Массив с id модели и amount добавляемого количества
     * @var int
     */
    public function updateBasket(array $params) :int
    {
        return $this->query("UPDATE basket SET amount = amount + :amount WHERE id=:id", 'rowCount', $params);
    }

    /**
     * Функция вывода всех еще не заказанных товаров из корзины пользователя user_id
     * @var int $id Идентификацционный номер пользователя id
     * @return array
     */
    public function allFromBasket(int $id) :array
    {
        return $this->query("SELECT goods.id as good_id, goods.photo, goods.name, goods.price, goods.new_price, basket.amount, basket.id FROM goods RIGHT JOIN basket on goods.id=basket.good_id WHERE basket.user_id=:user_id AND basket.order_id IS NULL", 'fetchAll', ['user_id' => $id]);
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
