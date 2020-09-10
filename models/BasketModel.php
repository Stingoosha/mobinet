<?php

namespace models;
//
// модель корзины
//
class BasketModel extends BaseModel
{
    protected $table = 'basket';

    //
    // функция проверки, были ли раннее добавлены такие же модели good_id этим пользователем user_id
    //
    public function isPhoneExists($params)
    {
        return $this->query("SELECT * FROM $this->table WHERE user_id=:user_id AND good_id=:good_id AND order_id IS NULL", 'fetch', $params);
    }

    //
    // функция обновления количества amount ранне добавленного товара при новом заказе одним и тем же пользователем по id корзины
    //
    public function updateBasket($params)
    {
        return $this->query("UPDATE basket SET amount = amount + :amount WHERE id=:id", 'rowCount', $params);
    }

    //
    // функция вывода всех еще не заказанных товаров из корзины пользователя user_id
    //
    public function allFromBasket($id)
    {
        return $this->query("SELECT goods.id as good_id, goods.photo, goods.name, goods.price, goods.new_price, basket.amount, basket.id FROM goods RIGHT JOIN basket on goods.id=basket.good_id WHERE basket.user_id=:user_id AND basket.order_id IS NULL", 'fetchAll', ['user_id' => $id]);
    }
}
