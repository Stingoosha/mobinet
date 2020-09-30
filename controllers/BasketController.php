<?php
namespace controllers;

use models\OrderModel;
use resources\Requester;

/**
 * Контроллер корзины
 */
class BasketController extends BaseController
{
    /**
     * @var OrderModel $order Модель заказа
     */
    protected $order;

	/**
	 * Функция отрабатывается перед основным action
	 */
	public function before()
	{
        parent::before();
        $this->order = new OrderModel(); // создается экземпляр модели заказа
    }

    /**
	 * страница корзины пользователя '/basket'
	 */
    public function index()
    {
        $this->layout['active'] = 'basket';

        // var_dump($_SESSION);die;
        if (isset($_SESSION['userId'])) { // проверка, есть ли у пользователя свой id
            $id = (int)$_SESSION['userId'];

            $this->orders = $this->order->allWhere('id_user=' . $id); // получение всех заказов пользователя
            // var_dump($this->orders);die;
            $this->phones = $this->basket->allFromBasket($id); // получение всех товаров корзины пользователя
            // var_dump($this->phones[0]['new_price']);die;

        } else {
            // отправляем пустые массивы
            $this->orders = [];
            $this->phones = [];
        }

        echo $this->blade->render('pages/basket', [
            'layout' => $this->layout,
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
		// var_dump($_POST);die;
		$userId = (int)($_SESSION['userId'] ?? null); // получение id пользователя, кликнувшего "Купить"
		$phoneId = (int)($_POST['phone_id'] ?? null);
		$amount = (int)($_POST['amount'] ?? null);
		$messId = ($_POST['message_id'] ?? null);

		if (!$userId) { // если у пользователя еще нет id, то создание нового пользователя и сохранение его id
            $userId = $this->user->createTempUser();
			$this->session('userId', $userId);
		}
		// var_dump($userId);die;

		if ($amount < 1) {
			echo "Введите корректное количество!";
		} else {
			// проверка, были ли раннее добавлены такие же модели этим пользователем
			// если были, то их количество увеличивается
			// если не было, то эта модель добавляется в корзину
            $phone = $this->basket->isPhoneExists(['id_user' => $userId, 'id_good' => $phoneId]);
            // var_dump($phone);die;
			if ($phone) {
				if ($this->basket->updateBasket(['id_basket' => $phone['id_basket'], 'amount' => $amount])) {
					echo 'Товар добавлен в корзину';
				}
			} elseif ($this->basket->insert(['id_user' => $userId, 'id_good' => $phoneId, 'amount' => $amount])) {
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
        $this->basket->delete('id_good=' . $id);

        header("Location: /basket");
        exit;
    }
}
