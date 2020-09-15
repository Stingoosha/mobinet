<?php
namespace controllers;

use models\BasketModel;
use models\OrderModel;
use models\UserModel;
use resources\Requester;

/**
 * Контроллер корзины
 */
class BasketController extends BaseController
{
    /**
     * @var BasketModel $basket Модель корзины
     * @var OrderModel $order Модель заказа
     */
    protected $basket;
    protected $order;

	/**
	 * Конструктор
	 */
	public function __construct()
	{
        $this->basket = new BasketModel(); // создается экземпляр модели корзины
        $this->order = new OrderModel(); // создается экземпляр модели заказа
    }

    /**
	 * страница корзины пользователя '/basket'
	 */
    public function index()
    {
        $this->active = 'basket';

        // var_dump($_SESSION);die;
        if (isset($_SESSION['userId'])) { // проверка, есть ли у пользователя свой id
            $id = (int)$_SESSION['userId'];

            $this->orders = $this->order->allOrders($id); // получение всех заказов пользователя
            // var_dump($orders);die;
            $this->phones = $this->basket->allFromBasket($id); // получение всех товаров корзины пользователя
            // var_dump($phones);die;

            // if (!$this->orders && !$this->phones) { // проверка на отсутствие данных по заказам и товарам корзины
            //     // запрет на вход в пустую корзину
            //     $this->redirect('Извините, Вы не можете открыть пустую корзину!', 'phones');
            // }
        } else {
            // отправляем пустые массивы
            $this->orders = [];
            $this->phones = [];
        }

        echo $this->blade->render('pages/basket', [
            'userData' => $this->userData,
            'active' => $this->active,
            'orders' => $this->orders,
            'phones' => $this->phones,
            'summ' => null,
            'summFinal' => null,
            'pathImgSmall' => self::$constants['PATH_IMG_SMALL']
        ]);
    }

    /**
     * функция добавления товаров в корзину '/tobasket' (с использованием ajax)
     */
	public function tobasket()
	{
		// var_dump($_SESSION);die;
		$userId = (int)($_SESSION['userId'] ?? null); // получение id пользователя, кликнувшего "Купить"
		$phoneId = (int)($_POST['phone_id'] ?? null);
		$amount = (int)($_POST['amount'] ?? null);
		$messId = ($_POST['message_id'] ?? null);

		if (!$userId) { // если у пользователя еще нет id, то создание нового пользователя и сохранение его id
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
        $id = Requester::id();

        // удаление товара
        $this->basket->delete("good_id = $id");

        header("Location: /basket");
        exit;
    }
}
