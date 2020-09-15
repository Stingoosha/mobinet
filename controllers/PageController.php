<?php
namespace controllers;

use models\PageModel;
use models\BrendModel;
use resources\Requester;

/**
 * Контроллер показа страниц сайта
 */
class PageController extends BaseController
{
	/**
     * @var PageModel $page Модель страницы
     * @var BrendModel $brend Модель бренда
     */
	private $page;
	private $brend;

	/**
	 * Конструктор
	 */
	public function __construct()
	{
		$this->page = new PageModel(); // создается экземпляр модели страницы
		$this->brend = new BrendModel(); // создается экземпляр бренда
	}

	/**
	 * Главная страница сайта '/' или '/index.php'
	 */
	public function index()
	{
		$this->active = 'index';

		echo $this->blade->render('pages/index', [
			'userData' => $this->userData,
			'active' => $this->active
		]);
	}

	/**
	 * Страница каталога телефонов '/phones'
	 */
	public function catalog()
	{
		$this->active = 'catalog';
		$this->brends = $this->brend->all(); // получение всех брендов
		$this->phones = $this->page->some(self::$constants['TOTAL_ON_PAGE']); // получение определенного количества моделей

		// var_dump($phones);die;

		echo $this->blade->render('pages/catalog', [
			'userData' => $this->userData,
		  'active' => $this->active,
		  'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
		  'total' => self::$constants['TOTAL_ON_PAGE'],
		  'brends' => $this->brends,
		  'phones' => $this->phones
		]);
	}

	/**
	 * Страница показа определенной модели телефона '/phones/{id}'
	 */
	public function show()
	{
		$id = Requester::id(); // получение id определенной модели телефона

		$phone = $this->page->one($id); // получение данных по id телефона

		echo $this->blade->render('pages/show', [
			'userData' => $this->userData,
			'pathImgLarge' => self::$constants['PATH_IMG_LARGE'],
			'phone' => $phone,
			'userId' => $_SESSION['userId'] ?? ''
		]);
	}

	/**
	 * Страница показа результатов поиска
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
			'userData' => $this->userData,
			'active' => $active,
			'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
			'phones' => $phones,
			'brends' => $brends ?? ''
		]);
	}

	/**
	 * Страница показа контактов '/contacts'
	 */
	public function contacts()
	{
		$active = 'contacts';

		echo $this->blade->render('pages/contacts', [
			'userData' => $this->userData,
			'active' => $this->active
		]);
	}

	/**
	 * Функция показа дополнительных моделей при клике на кнопку "Показать еще" '/getPhones' (с использованием ajax)
	 */
	public function showMore()
	{
		$lastId = (int)($_POST['lastId'] ?? null); // получение id последнего телефона на странице
		// получение необходимого количества моделей, начиная с полученного id последней модели на странице
		$phones = $this->page->part($lastId, self::$constants['TOTAL_ON_PAGE']);

		echo json_encode($phones);
	}

	/**
	 * Функция показа моделей, принадлежащих выделенному пользователем бренду (или группы брендов)
	 */
	public function selectBrend()
	{
		$checked = $_POST['checked']; // получение id всех отмеченных брендов
		// образование условия WHERE для SQL-запроса
		$checked = explode(',', $checked);
		$where = ' id_brend=' . implode(' OR id_brend=', $checked);

		$phones = $this->page->getBrends($where); // получение всех моделей по отмеченным брендам

		echo json_encode($phones);
	}

	/**
	 * Страница показа ошибки при неправильном вводе URL-адреса
	 */
	public function error404()
	{
		$this->title = 'Заблудились?';

		echo $this->blade->render('errors/404');
	}
}
