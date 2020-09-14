<?php
namespace controllers;

use Jenssegers\Blade\Blade;
use models\UserModel;

/**
 * Базовый контроллер сайта
 */
abstract class BaseController extends AbstractController
{
	/**
	 * @var string $title Заголовок страницы
	 * @var string $content Содержание страницы
	 * @var string $active Маркер активности страницы
	 * @var Blade $blade Модель шаблонизатора Blade
	 * @var UserModel $user Модель пользователя
	 * @var int $userRole Роль пользователя
	 * @var array $phones Массив телефонов
	 * @var array $brends Массив брендов
	 * @var array $orders Массив заказов
	 */
	protected $title;
	protected $content;
	protected $active;
	protected $blade;
	protected $user;
	protected $userRole;
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

		// var_dump(self::$constants);die;
		$this->blade = new Blade('views', 'cache'); // создаем экземпляр модели шаблонизатора Blade
		$this->user = new UserModel(); // создаем экземпляр пользователя

		$this->saveLogs(); // сохраняем открытую страницу в логах

		// определяем роль пользователя, если он есть в БД
		if (isset($_SESSION['userId'])) {
			$userId = (int)$_SESSION['userId'];
			$this->userRole = $this->user->getUserRole($userId);
		}
	}

}
