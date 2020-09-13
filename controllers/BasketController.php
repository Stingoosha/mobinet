<?php

namespace controllers;

use models\BasketModel;
use models\OrderModel;
use models\UserModel;
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

    /**
	 * страница корзины пользователя '/basket'
	 */
    public function index()
    {
        $this->active = 'basket';
        $phones = [];
        $orders = [];

        // var_dump($_SESSION);die;
        // проверка, есть ли у пользователя свой id
        if (isset($_SESSION['userId'])) {
            $id = (int)$_SESSION['userId'];
            // получение всех заказов пользователя
            $orders = $this->order->allOrders($id);
            // var_dump($orders);die;
            // получение всех товаров корзины пользователя
            $phones = $this->basket->allFromBasket($id);
            // var_dump($phones);die;
            // проверка на отсутствие данных по заказам и товарам корзины
            if (!$orders && !$phones) {
                // запрет на вход в пустую корзину
                $this->redirect('Извините, Вы не можете открыть пустую корзину!', 'phones');
            }
        } else {
            // запрет на вход в пустую корзину
            $this->redirect('Извините, Вы не можете открыть пустую корзину!', 'phones');
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

    //
	// функция добавления товаров в корзину '/tobasket'
	// (с использованием ajax)
	//
	public function tobasket()
	{
		// var_dump($_SESSION);die;
		// получение id пользователя, кликнувшего "Купить"
		$userId = (int)($_SESSION['userId'] ?? null);
		$phoneId = (int)($_POST['phone_id'] ?? null);
		$amount = (int)($_POST['amount'] ?? null);
		$messId = ($_POST['message_id'] ?? null);

		// если у пользователя еще нет id, то создание нового пользователя и сохранение его id
		if (!$userId) {
			$user = new UserModel();
            $userId = $user->createTempUser();
			$this->session('userId', $userId);
		}
		// var_dump($userId);die;

		if ($amount < 1) {
			echo "Введите корректное количество!";
		} else {
			// проверка, были ли раннее добавлены такие же модели этим пользователем
			// если были, то их количество увеличивается
			// если не было, то эта модель добавляется в корзину
			$phone = $this->basket->isPhoneExists(['user_id' => $userId, 'good_id' => $phoneId]);
			if ($phone) {
				if ($this->basket->updateBasket(['id' => $phone['id'], 'amount' => $amount])) {
					echo 'Товар добавлен в корзину';
				}
			} elseif ($this->basket->insert(['user_id' => $userId, 'good_id' => $phoneId, 'amount' => $amount])) {
				echo 'Товар добавлен в корзину';
			} else {
				echo 'Товар не был добавлен по техническим причинам!';
			}
		}
		exit();
	}

    /**
	 * функция удаления товара из корзины '/basket/{id}/remove'
	 */
    public function remove()
    {
        // получение id удаляемого товара
        $id = Requester::getInstance()->id();

        // удаление товара
        $this->basket->delete("good_id = $id");

        header("Location: /basket");
        exit;
    }
}
