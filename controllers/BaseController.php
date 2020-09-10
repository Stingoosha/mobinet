<?php
namespace controllers;

use Jenssegers\Blade\Blade;
//
// Базовый контроллер сайта.
//
abstract class BaseController extends AbstractController
{
	protected const TOTAL_ON_PAGE = 12;
	protected const PATH_IMG_SMALL = 'public/img/small/';
	protected const PATH_IMG_LARGE = 'public/img/large/';
    protected const TABLES = ['goods', 'params', 'users', 'basket', 'orders', 'discounts'];
	protected $title; // заголовок страницы
	protected $content; // содержание страницы
	protected $message = ''; // информативное сообщение на странице
	protected $active; // маркер активности страницы
	protected $blade; // модель шаблонизатора Blade

	// функция отрабатывается перед основным action
	protected function before()
	{
		session_start();
		// var_dump($_SESSION);die;
		$this->blade = new Blade('views', 'cache'); // создаем экземпляр модели шаблонизатора Blade
		$this->saveLogs();
	}

}
