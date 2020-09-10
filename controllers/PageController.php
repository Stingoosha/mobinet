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

	//
	// главная страница сайта '/'
	//
	public function index()
	{
		$this->active = 'index';

		echo $this->blade->render('pages/index', [
			'active' => $this->active
		]);
	}

	//
	// страница каталога телефонов '/phones'
	//
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

	//
	// страница показа определенной модели телефона '/phones/{id}'
	//
	public function show()
	{
		// получение id определенной модели телефона
		$id = Requester::getInstance()->id();

		$phone = $this->page->one($id);

		echo $this->blade->render('pages/show', [
			'pathImgLarge' => self::PATH_IMG_LARGE,
			'phone' => $phone,
			'userId' => $_SESSION['userId'] ?? ''
		]);
	}

	//
	// страница показа контактов '/contacts'
	//
	public function contacts()
	{
		$active = 'contacts';

		echo $this->blade->render('pages/contacts', [
			'active' => $this->active
		]);
	}

	//
	// функция показа дополнительных товаров при клике на кнопку "Показать еще" '/getPhones'
	// (с использованием ajax)
	//
	public function getPhones()
	{
		// получение id последнего телефона на странице
		$lastId = (int)($_POST['lastId'] ?? null);

		$phones = $this->page->part($lastId, self::TOTAL_ON_PAGE);

		echo json_encode($phones);
	}

	//
	// страница показа ошибки при неправильном вводе URL-адреса
	//
	public function error404()
	{
		$this->title = 'Заблудились?';

		echo $this->blade->render('errors/404');
	}
}
