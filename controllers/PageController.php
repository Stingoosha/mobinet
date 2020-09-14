<?php
namespace controllers;

use models\PageModel;
use models\BrendModel;
use resources\Requester;

//
// Контроллер страницы чтения.
//

class PageController extends BaseController
{
	private $page; // модель страницы
	private $brend; // модель бренда

	/**
	 * Конструктор
	 */
	public function __construct()
	{
		// создается экземпляр модели страницы
		$this->page = new PageModel();
		// создается экземпляр бренда
		$this->brend = new BrendModel();
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
		$brends = $this->brend->all();
		$phones = $this->page->some(self::$constants['TOTAL_ON_PAGE']);

		// var_dump($phones);die;

		echo $this->blade->render('pages/catalog', [
		  'active' => $this->active,
		  'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
		  'total' => self::$constants['TOTAL_ON_PAGE'],
		  'brends' => $brends,
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
			'pathImgLarge' => self::$constants['PATH_IMG_LARGE'],
			'phone' => $phone,
			'userId' => $_SESSION['userId'] ?? ''
		]);
	}

	/**
	 * страница показа результатов поиска
	 */
	public function search()
	{
		$active = 'catalog';
		$this->page->clear($_POST);
		$search = $_POST['search'] ?? '';
		// var_dump($search);die;
		if (!$search) {
			$this->redirect('Пожалуйста, введите данные для поиска!', 'phones');
		} else {
			$phones = $this->page->search($search);
			$brends = $this->brend->all();

			if($phones) {
				$spoiler = $this->page->getSpoiler(count($phones), ['ь', 'и', 'ей']);
				$this->flash('Результаты поиска по запросу "' . $search . '". Всего ' . count($phones) . ' модел' . $spoiler);
			} else {
				$this->flash('Результаты поиска по запросу "' . $search . '". Не найдено ни одной модели');
			}
		}

		echo $this->blade->render('pages/catalog', [
			'active' => $active,
			'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
			'phones' => $phones,
			'brends' => $brends ?? ''
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
	public function showMore()
	{
		// получение id последнего телефона на странице
		$lastId = (int)($_POST['lastId'] ?? null);

		$phones = $this->page->part($lastId, self::$constants['TOTAL_ON_PAGE']);

		echo json_encode($phones);
	}

	public function selectBrend()
	{
		// получение id всех отмеченных брендов
		$checked = $_POST['checked'];

		$checked = explode(',', $checked);
		$where = ' id_brend=' . implode(' OR id_brend=', $checked);

		$phones = $this->page->getBrends($where);

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
