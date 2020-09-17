<?php
namespace controllers\admin;

use controllers\BaseController;
use models\UserModel;
use models\RoleModel;
use resources\Requester;
/**
 * Контроллер администратора пользователей
 */
class AdminUserController extends BaseController
{
    /**
     * @var UserModel $user Модель пользователя
     * @var $users Массив всех пользователей
     */
    protected $user;
    protected $users = [];

	/**
	 * Конструктор
	 */
    public function __construct()
	{
        $this->user = new UserModel(); // создается экземпляр пользователя
    }

    /**
     * Страница администрирования пользователей
     */
    protected function index()
    {
        $this->users = $this->user->all();

        $role = new RoleModel();
        $roles = $role->all();

        echo $this->blade->render('pages/admin/users', [
            'userData' => $this->userData,
            'users' => $this->users,
            'roles' => $roles
        ]);
    }

    /**
     * Страница показа детальной информации о пользователе
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
}
