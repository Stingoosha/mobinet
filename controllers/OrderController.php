<?php
namespace controllers;

use models\OrderModel;

/**
 * Контроллер заказов
 */
class OrderController extends BaseController
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
	 * страница заказа '/order'
	 */
    public function index()
    {
        $this->active = 'basket';

        if (isset($_SESSION['userId'])) { // проверка, есть ли у пользователя свой id
            $id = $_SESSION['userId'];
            $this->phones = $this->basket->allFromBasket($id); // получение всех товаров корзины пользователя
            // var_dump($phones);die;
        } else {
            // запрет на оформление заказа без наличия id пользователя
            $this->redirect('Извините, по техническим причинам Вы не можете сделать заказ!', 'phones');
        }

        echo $this->blade->render('pages/order', [
            'userData' => $this->userData,
            'active' => $this->active,
            'phones' => $this->phones,
            'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
            'summ' => null
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
            $this->redirect('Ваш заказ отправлен на обработку! Наш менеджер свяжется с Вами в течение 5 минут!', 'basket');
        }

        $this->redirect('По техническим причинам заказ не был обработан. Попробуйте позже!','basket');
    }
}
