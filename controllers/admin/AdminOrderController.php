<?php
namespace controllers\admin;

use controllers\BaseController;
use models\OrderModel;
use models\PageModel;
use resources\Requester;

/**
 * Контроллер администратора заказов
 */
class AdminOrderController extends BaseController
{
    /**
     * @var OrderModel $order Модель заказа
     * @var $orders Массив всех заказов
     */
    private $order;
    protected $orders = [];

	/**
	 * Функция отрабатывается перед основным action
	 */
    public function before()
	{
        parent::before();
        $this->order = new OrderModel(); // создается экземпляр модели заказа
    }

    /**
     * Страница администрирования заказов
     */
    protected function index()
    {
        $this->orders = $this->order->all();

        echo $this->blade->render('pages/admin/orders', [
            'userData' => $this->userData,
            'orders' => $this->orders,
            'statuses' => self::$constants['ORDER_STATUSES']
        ]);
    }

    /**
     * Страница показа деталей заказа
     */
    protected function show()
    {
        $orderId = (int)Requester::id(); // получение id просматриваемого заказа
        $phones = $this->order->getOrderData($orderId);
        $order = $this->order->one('*', 'order_id=' . $orderId);
        // var_dump($order);die;

        echo $this->blade->render('pages/admin/order', [
            'userData' => $this->userData,
            'phones' => $phones,
			'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
            'order' => $order
        ]);
    }

    /**
     * Функция изменения статуса заказа
     */
    protected function edit()
    {
        $orderId = (int)Requester::id(); // получение id ордера

        if ($this->isPost()) {
            // var_dump($_POST);die;
            $this->order->clear($_POST);

            if ($this->order->update(['status' => $_POST['newStatus']], 'order_id=' . $orderId)) {
                $this->flash('Статус заказа №' . $orderId . ' успешно изменен на "' . $_POST['newStatus'] . '"!');
            } else {
                $this->flash('По техническим причинам изменить статус заказа №' . $orderId . ' на "' . $_POST['newStatus'] . '" не удалось! Поробуйте позже!');
            }
        }
        $this->orders = $this->order->all();
        // var_dump(self::$constants['ORDER_STATUSES']);die;
        echo $this->blade->render('pages/admin/orders', [
            'userData' => $this->userData,
            'orders' => $this->orders,
            'newOrderId' => $orderId,
            'statuses' => self::$constants['ORDER_STATUSES']
        ]);
    }
}
