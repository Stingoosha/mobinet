<?php

namespace models;

class BasketModel extends BaseModel
{
    protected $table = 'basket';

    public function isPhoneExists($params)
    {
        return $this->query("SELECT * FROM $this->table WHERE user_id=:user_id AND good_id=:good_id AND order_id IS NULL", 'fetch', $params);
    }

    public function updateBasket($params)
    {
        return $this->query("UPDATE basket SET amount = amount + :amount WHERE id=:id", 'rowCount', $params);
    }

    public function allFromBasket($id)
    {
        return $this->query("SELECT goods.id as good_id, goods.photo, goods.name, goods.price, goods.new_price, basket.amount, basket.id FROM goods RIGHT JOIN basket on goods.id=basket.good_id WHERE basket.user_id=:user_id AND basket.order_id IS NULL", 'fetchAll', ['user_id' => $id]);
    }
}
