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
	 * @var array $userData Данные пользователя
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
	protected $userData = [];
	protected $keywords = [];
	protected $phones = [];
	protected $brands = [];
	protected $orders = [];

	/**
	 * Функция инициализации базового контроллера (подключает массив с константами)
	 * @var string $constantsPath Путь до массива с константами
	 * @var string $verificationPath Путь к файлу с верификацией страниц
	 * @return void
	 */
    public static function init(string $constantsPath, string $verificationPath) :void
    {
        self::$constants = include $constantsPath;
        self::$verificators = include $verificationPath;
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
		$this->userData = $this->user->userProfile();
		// проверяем доступна ли страница
		if (!$this->access($this->userData)) {
			$this->redirect('', '404');
		}
		// var_dump($this->userData);die;
		// определяем количество товара в корзине
		if (isset($_SESSION['userId'])) {
			$this->userData['basket_size'] = $this->basket->getBasketSize($_SESSION['userId']);
		}
	}

}
