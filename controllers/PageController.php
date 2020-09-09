<?php
namespace controllers;

use models\PageModel;
use models\UserModel;
use models\BasketModel;
use resources\Requester;

//
// Контроллер страницы чтения.
//

class PageController extends BaseController
{
	private $page; // модель страницы

	/**
	 * Конструктор
	 */
	public function __construct()
	{
		// создается экземпляр модели страницы
		$this->page = new PageModel();
	}

	// главная страница сайта '/'
	public function index()
	{
		$this->active = 'index';

		// var_dump($GLOBALS);die;
		echo $this->blade->render('pages/index', [
			'active' => $this->active
		]);
	}

	// страница каталога телефонов '/phones'
	public function catalog()
	{
		$this->active = 'catalog';
		$phones = $this->page->some(self::TABLES[0], self::TOTAL_ON_PAGE);

		// var_dump($phones);die;

		echo $this->blade->render('pages/catalog', [
		  'active' => $this->active,
		  'pathImgSmall' => self::PATH_IMG_SMALL,
		  'total' => self::TOTAL_ON_PAGE,
		  'phones' => $phones
		]);
	}

	public function show()
	{
		$id = Requester::getInstance()->id();

		$phone = $this->page->one($id);

		echo $this->blade->render('pages/show', [
			'pathImgLarge' => self::PATH_IMG_LARGE,
			'phone' => $phone,
			'userId' => $_SESSION['userId'] ?? ''
		]);
	}

	public function contacts()
	{
		$active = 'contacts';

		echo $this->blade->render('pages/contacts', [
			'active' => $this->active
		]);
	}

	public function getPhones()
	{
		$lastId = (int)($_POST['lastId'] ?? null);

		$phones = $this->page->part(self::TABLES[0], $lastId, self::TOTAL_ON_PAGE);

		echo json_encode($phones);
	}

	public function tobasket()
	{
		// var_dump($_POST);die;
		$userId = (int)($_POST['user_id'] ?? null);
		$phoneId = (int)($_POST['phone_id'] ?? null);
		$amount = (int)($_POST['amount'] ?? null);
		$messId = ($_POST['message_id'] ?? null);

		if (!$userId) {
			$user = new UserModel();
			$userId = $user->insert(['name' => 'temp_shmemp_user_puser']);
			$this->session('userId', $userId);
		}
		// var_dump($userId);die;

		if ($amount < 1) {
			echo "Введите корректное количество!";
		} else {
			$basket = new BasketModel();
			$phone = $basket->isPhoneExists(['user_id' => $userId, 'good_id' => $phoneId]);
			if ($phone) {
				if ($basket->updateBasket(['id' => $phone['id'], 'amount' => $amount])) {
					echo 'Товар добавлен в корзину';
				}
			} elseif ($basket->insert(['user_id' => $userId, 'good_id' => $phoneId, 'amount' => $amount])) {
				echo 'Товар добавлен в корзину';
			} else {
				echo 'Товар не был добавлен по техническим причинам!';
			}
		}
		exit();
	}

	public function error404()
	{
		$this->title = 'Заблудились?';

		echo $this->blade->render('errors/404');
	}
}
