<?php
namespace controllers;

use Jenssegers\Blade\Blade;
use models\UserModel;
use models\BasketModel;
use models\TokenModel;

/**
 * Базовый контроллер сайта
 */
abstract class BaseController extends AbstractController
{
	/**
	 * @var Blade $blade Модель шаблонизатора Blade
	 * @var UserModel $user Модель пользователя
	 * @var BasketModel $basket Модель корзины
	 * @var string $title Заголовок страницы
	 * @var string $content Содержание страницы
	 * @var string $active Маркер активности страницы
	 * @var array $description Мета-описание страницы сайта для поисковых систем
	 * @var array $layout Данные, передаваемые на страницу layout
	 * @var array $user Данные пользователя
	 * @var array $access Данные доступа страниц
	 * @var array $keywords Массив ключевых слов и их значений для поисковых систем
	 * @var array $phones Массив телефонов
	 * @var array $brands Массив брендов
	 * @var array $orders Массив заказов
	 */
	protected $blade;
	protected $user;
	protected $basket;
	protected $title;
	protected $content;
	protected $active;
	protected $description = '';
	protected $layout = [
		'user' => [],
		'access' => []
	];
	protected $keywords = [];
	protected $phones = [];
	protected $brands = [];
	protected $orders = [];

	/**
	 * Функция инициализации базового контроллера (подключает массив с константами)
	 * @var string $constantsPath Путь до массива с константами
	 * @var string $accessPath Путь к файлу с верификацией страниц
	 * @return void
	 */
    public static function init(string $constantsPath, string $accessPath) :void
    {
        self::$constants = include $constantsPath;
        self::$access = include $accessPath;
    }

	/**
	 * Функция отрабатывается перед основным action
	 */
	protected function before()
	{
		session_start(); // стартуем сессию

		// var_dump(get_class($GLOBALS['routingData'][0]));die;
		$this->blade = new Blade('views', 'cache'); // создаем экземпляр модели шаблонизатора Blade
		$this->user = new UserModel(); // создаем экземпляр пользователя
		$this->basket = new BasketModel(); // создаем экземпляр пользователя

		$this->saveLogs(); // сохраняем открытую страницу в логах

		// проверяем пользователя
		$this->layout['user'] = $this->user->userProfile();
		// проверяем доступна ли страница
		if (!$this->access($this->layout['user'])) {
			$this->redirect('', '404');
		}
		// добавляем данные доступа к страницам
		$this->layout['access'] = self::$access;
		// var_dump($this->userData);die;
		// определяем количество товара в корзине
		if (isset($_SESSION['userId'])) {
			$this->layout['user']['basket_size'] = $this->basket->getBasketSize($_SESSION['userId']);
		}
	}

}
