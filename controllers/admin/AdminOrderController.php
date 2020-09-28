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
     */
    private $order;

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
            'layout' => $this->layout,
            'orders' => $this->orders,
            'statuses' => self::$constants['ORDER_STATUSES'],
            'newOrderId' => null
        ]);
    }

    /**
     * Страница показа деталей заказа
     */
    protected function show()
    {
        $orderId = Requester::id(); // получение id просматриваемого заказа
        $this->phones = $this->order->getOrderData($orderId);
        $order = $this->order->one('*', 'id_order=' . $orderId);
        // var_dump($order);die;

        echo $this->blade->render('pages/admin/order', [
            'layout' => $this->layout,
            'phones' => $this->phones,
			'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
            'order' => $order
        ]);
    }

    /**
     * Функция изменения статуса заказа
     */
    protected function edit()
    {
        $orderId = Requester::id(); // получение id ордера

        // var_dump($_POST);die;
        $this->order->clear($_POST);

        if ($this->order->update(['status' => $_POST['newStatus']], 'id_order=' . $orderId)) {
            $this->flash('Статус заказа №' . $orderId . ' успешно изменен на "' . $_POST['newStatus'] . '"!');
        } else {
            $this->flash('По техническим причинам изменить статус заказа №' . $orderId . ' на "' . $_POST['newStatus'] . '" не удалось! Поробуйте позже!');
        }

        $this->orders = $this->order->all();
        // var_dump(self::$constants['ORDER_STATUSES']);die;
        echo $this->blade->render('pages/admin/orders', [
            'layout' => $this->layout,
            'orders' => $this->orders,
            'newOrderId' => $orderId,
            'statuses' => self::$constants['ORDER_STATUSES']
        ]);
    }
}
