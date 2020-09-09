<?php

namespace controllers;

use models\BasketModel;
use models\OrderModel;
use resources\Requester;

class BasketController extends BaseController
{
    protected $basket; // модель корзины
    protected $order; // модель заказа

	/**
	 * Конструктор
	 */
	public function __construct()
	{
        // создается экземпляр модели корзины
        $this->basket = new BasketModel();
        // создается экземпляр модели заказа
        $this->order = new OrderModel();
    }

    public function index()
    {
        $this->active = 'basket';

        if (isset($_SESSION['userId'])) {
            $id = $_SESSION['userId'];
            $orders = $this->order->allOrders($id);
            $phones = $this->basket->allFromBasket($id);
            // var_dump($phones);die;
        }

        echo $this->blade->render('pages/basket', [
            'active' => $this->active,
            'orders' => $orders,
            'phones' => $phones,
            'message' => $this->message,
            'summ' => null,
            'summFinal' => null,
            'pathImgSmall' => self::PATH_IMG_SMALL
        ]);
    }

    public function remove()
    {
        $id = Requester::getInstance()->id();

        $this->basket->delete("good_id = $id");

        header("Location: /basket");
        exit;
    }
}
