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
	 * @var array $brends Массив брендов
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
	protected $brends = [];
	protected $orders = [];

	/**
	 * функция инициализации базового контроллера (подключает массив с константами)
	 * @var string $constantsPath Путь до массива с константами
	 * @return void
	 */
    public static function init(string $constantsPath) :void
    {
        self::$constants = include $constantsPath;
    }

	/**
	 * функция отрабатывается перед основным action
	 */
	protected function before()
	{
		session_start(); // стартуем сессию

		// var_dump($_COOKIE);die;
		$this->blade = new Blade('views', 'cache'); // создаем экземпляр модели шаблонизатора Blade
		$this->user = new UserModel(); // создаем экземпляр пользователя

		$this->saveLogs(); // сохраняем открытую страницу в логах

		// проверяем пользователя
		if ($this->checkUser()) {
			$this->userData = $this->user->getUserData($_SESSION['userId']);
			// var_dump($this->userData);die;
		}
	}

	/**
	 * Функция проверки пользователя
	 */
	public function checkUser()
	{
		// проверяем, сохранились ли в куках что-то
		// если одного чего-то нет, все удаляем и направляем на регистрацию
		// если все есть, но токен устарел, обновляем токен
		// проверяем, есть ли сессия
		// если есть и она не совпадают с кукой, все удаляем и направляем на регистрацию
		// если сессии нет, создаем
		// если совпадают, выдаем данные о пользователе
		if (isset($_SESSION['userId'])) {
			return true;
		}
		return false;
    }

}
