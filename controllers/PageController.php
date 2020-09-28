<?php
namespace controllers;

use models\PageModel;
use models\BrandModel;
use models\ParameterModel;
use resources\Requester;

/**
 * Контроллер показа страниц сайта
 */
class PageController extends BaseController
{
	/**
     * @var PageModel $page Модель страницы
     * @var BrandModel $brand Модель бренда
     */
	private $page;
	private $brand;

	/**
	 * Функция отрабатывается перед основным action
	 */
	public function before()
	{
		parent::before();
		$this->page = new PageModel(); // создается экземпляр модели страницы
		$this->brand = new BrandModel(); // создается экземпляр бренда
	}

	/**
	 * Главная страница сайта '/' или '/index.php'
	 */
	public function index()
	{
		$this->layout['active'] = 'index';

		echo $this->blade->render('pages/index', [
			'layout' => $this->layout
		]);
	}

	/**
	 * Страница каталога телефонов '/phones'
	 */
	public function catalog()
	{
		$this->layout['active'] = 'catalog';
		$this->brands = $this->brand->all(); // получение всех брендов
		$this->phones = $this->page->some(self::$constants['TOTAL_ON_PAGE']); // получение определенного количества моделей

		// var_dump($phones);die;

		echo $this->blade->render('pages/catalog', [
		  'layout' => $this->layout,
		  'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
		  'total' => self::$constants['TOTAL_ON_PAGE'],
		  'brands' => $this->brands,
		  'phones' => $this->phones
		]);
	}

	/**
	 * Страница показа определенной модели телефона '/phones/{id}'
	 */
	public function show()
	{
		$phoneId = Requester::id(); // получение id определенной модели телефона

		$phone = $this->page->one('*', 'id_good=' . $phoneId); // получение данных по id телефона

		$param = new ParameterModel();
		$params = $param->one('*', 'id_good=' . $phoneId); // получение параметров телефона по его id

		echo $this->blade->render('pages/show', [
			'layout' => $this->layout,
			'pathImgLarge' => self::$constants['PATH_IMG_LARGE'],
			'phone' => $phone,
			'params' => $params,
			'userId' => $_SESSION['userId'] ?? ''
		]);
	}

	/**
	 * Страница показа результатов поиска
	 */
	public function search()
	{
		$this->layout['active'] = 'catalog';

		$this->page->clear($_POST);
		$search = $_POST['search'] ?? '';

		$this->brands = $this->brand->all();
		// var_dump($search);die;
		if (!$search) {
			$this->redirect('Пожалуйста, введите данные для поиска!', 'phones');
		} else {
			$this->phones = $this->page->search($search);

			if($this->phones) {
				$spoiler = $this->page->getSpoiler(count($this->phones), ['ь', 'и', 'ей']);
				$this->flash('Результаты поиска по запросу "' . $search . '". Всего ' . count($this->phones) . ' модел' . $spoiler);
			} else {
				$this->flash('Результаты поиска по запросу "' . $search . '". Не найдено ни одной модели');
			}
		}

		echo $this->blade->render('pages/catalog', [
			'layout' => $this->layout,
			'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
			'phones' => $this->phones,
			'brands' => $this->brands
		]);
	}

	/**
	 * Страница показа контактов '/contacts'
	 */
	public function contacts()
	{
		$this->layout['active'] = 'contacts';

		echo $this->blade->render('pages/contacts', [
			'layout' => $this->layout
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
	public function selectBrand()
	{
		$checked = $_POST['checked']; // получение id всех отмеченных брендов
		// образование условия WHERE для SQL-запроса
		$checked = explode(',', $checked);
		$where = ' id_brand=' . implode(' OR id_brand=', $checked);

		$phones = $this->page->allWhere($where); // получение всех моделей по отмеченным брендам

		echo json_encode($phones);
	}

	/**
	 * Страница показа ошибки при неправильном вводе URL-адреса
	 */
	public function error404()
	{
		$this->title = 'Заблудились?';

		echo $this->blade->render('errors/404', [
			'layout' => $this->layout
		]);
	}
}
