<?php

namespace controllers;

use models\OrderModel;
use models\BasketModel;

class OrderController extends BaseController
{
    protected $order; // модель заказа
    protected $basket; // модель корзины

    /**
	* Конструктор
	*/
	public function __construct()
	{
        // создается экземпляр модели заказа
        $this->order = new OrderModel();
        // создается экземпляр модели корзины
        $this->basket = new BasketModel();
    }

    public function index()
    {
        $this->active = 'basket';

        if (isset($_SESSION['userId'])) {
            $id = $_SESSION['userId'];
            $phones = $this->basket->allFromBasket($id);
            // var_dump($phones);die;
        }

        echo $this->blade->render('pages/order', [
            'active' => $this->active,
            'phones' => $phones,
            'pathImgSmall' => self::PATH_IMG_SMALL,
            'summ' => null,
            'message' => $this->message
        ]);
    }

    public function save()
    {
        $this->order->clearSum();

        $user = $_POST;
        $user['mailing'] = isset($_POST['mailing']) ? $_POST['mailing'] : 'off';
        $user['user_id'] = $_SESSION['userId'];

        // var_dump($user);die;
        if ($this->order->createOrder($user)) {
            $this->flash('Ваш заказ отправлен на обработку и будет выслан Вам в течении 12 часов!');
            header('Location: /phones');
            exit;
        }

        $this->flash('По техническим причинам заказ не был обработан. Попробуйте позже!');
        header('Location: /basket');
    }
}
