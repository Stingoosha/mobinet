<?php
namespace controllers;
//
// Базовый класс контроллера.
//
abstract class AbstractController
{
	// Функция отрабатывающая до основного метода
	protected abstract function before();

	public function Request($action)
	{
		$this->before();//метод вызывается до формирования данных для шаблона
		$this->$action();   //$this->action_index
	}

	//
	// Запрос произведен методом GET?
	//
	protected function IsGet()
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	//
	// Запрос произведен методом POST?
	//
	protected function IsPost()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	//
	// Запрос авторизован ли пользователь?
	//
	protected function isLogged()
	{
		return $_SESSION['isLogged'];
	}

	//
	// Установка флэш-сообщения
	//
	protected function flash(string $text) :void
	{
		$_SESSION['flash'] = $text;
	}

	//
	// Сохраняем просмотренные страницы в логи
	//
	protected function saveLogs()
	{
		$_SESSION['logs'][] = $_SERVER['REQUEST_URI'];
		if(count($_SESSION['logs']) > 5) {
			array_shift($_SESSION['logs']);
		}
	}

	protected function session($param, $val)
	{
		$_SESSION[$param] = $val;
	}

	// Если вызвали метод, которого нет - завершаем работу
	public function __call($name, $params){
        die('Не пишите фигню в url-адресе!!!');
	}
}
