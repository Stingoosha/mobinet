<?php
namespace controllers;

use Jenssegers\Blade\Blade;
use models\UserModel;
//
// Базовый контроллер сайта.
//
abstract class BaseController extends AbstractController
{
	protected static $constants = []; // массив констант
	protected $title; // заголовок страницы
	protected $content; // содержание страницы
	protected $message = ''; // информативное сообщение на странице
	protected $active; // маркер активности страницы
	protected $blade; // модель шаблонизатора Blade
	protected $user; // модель пользователя
	protected $userRole; // роль пользователя

	/**
	 * функция инициализации базового контроллера
	 */
    public static function init(string $constantsPath) :void
    {
        self::$constants = include $constantsPath;
    }

	// функция отрабатывается перед основным action
	protected function before()
	{
		session_start(); // стартуем сессию

		// var_dump(self::$constants);die;
		$this->blade = new Blade('views', 'cache'); // создаем экземпляр модели шаблонизатора Blade
		$this->user = new UserModel(); // создаем экземпляр пользователя

		$this->saveLogs(); // сохраняем открытую страницу в логах

		// определяем роль пользователя, если он есть в БД
		// if (isset($_SESSION['userId'])) {
		// 	$userId = (int)$_SESSION['userId'];
		// 	$this->userRole = $this->user->getUserRole($userId);
		// }
	}

}
