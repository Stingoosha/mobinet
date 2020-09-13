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

	/**
	 * страница заказа '/order'
	 */
    public function index()
    {
        $this->active = 'basket';

        // проверка, есть ли у пользователя свой id
        if (isset($_SESSION['userId'])) {
            $id = $_SESSION['userId'];
            // получение всех товаров корзины пользователя
            $phones = $this->basket->allFromBasket($id);
            // var_dump($phones);die;
        } else {
            // запрет на оформление заказа без наличия id пользователя
            $this->redirect('Извините, по техническим причинам Вы не можете сделать заказ!', 'phones');
        }

        echo $this->blade->render('pages/order', [
            'active' => $this->active,
            'phones' => $phones,
            'pathImgSmall' => self::PATH_IMG_SMALL,
            'summ' => null,
            'message' => $this->message
        ]);
    }

	/**
	 * функция сохранения заказа
	 */
    public function save()
    {
        // удаление промежуточной таблицы, служащей для расчета стоимости заказа
        $this->order->clearSum();

        // установка данных, введенных пользователем во время оформления заказа
        $user = $_POST;
        $user['mailing'] = isset($_POST['mailing']) ? $_POST['mailing'] : 'off';
        $user['user_id'] = $_SESSION['userId'];

        // создание оформленного заказа
        if ($this->order->createOrder($user)) {
            $this->redirect('Ваш заказ отправлен на обработку и будет выслан Вам в течении 12 часов!', 'basket');
        }

        $this->redirect('По техническим причинам заказ не был обработан. Попробуйте позже!','basket');
    }
}
