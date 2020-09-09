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
	protected $blade; // экземпляр шаблонизатора blade

	// функция отрабатывается перед основным action
	protected function before()
	{
		session_start();
		// var_dump($GLOBALS['path']);die;
		$this->blade = new Blade('views', 'cache');
		$this->saveLogs();
		$this->title = 'Название сайта';
		$this->content = '';
	}

}
