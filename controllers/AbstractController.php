<?php
namespace controllers;

/**
 * Базовый класс контроллера
 */
abstract class AbstractController
{
	/**
	 * массив констант
	 */
	protected static $constants = [];

	/**
	 * Абстрактная функция, отрабатывающая до основного метода
	 * @return void
	 */
	protected abstract function before();

	/**
	 * Функция вызова необходимого метода контроллера
	 * @return void
	 */
	public function Request($action) :void
	{
		$this->before();//метод вызывается до формирования данных для шаблона
		$this->$action();   //$this->action_index
	}

	/**
	 * Запрос произведен методом GET?
	 * @return bool
	 */
	protected function IsGet() :bool
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	/**
	 * Запрос произведен методом POST?
	 * @return bool
	 */
	protected function IsPost() :bool
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	/**
	 * Функция установки флэш-сообщения (его можно удалить прямо на странице либо оно исчезнет после открытия новой страницы)
	 * @var string $text Текст выводимого сообщения
	 * @var string $_SESSION['flash'] Переменная в сессии, куда сохраняется текст
	 * @return void
	 */
	protected function flash(string $text) :void
	{
		$_SESSION['flash'] = $text;
	}

	/**
	 * Функция установки переменной сессии
	 * @var string $param Название переменной сессии
	 * @var $val Значение, сохраняемое в переменной сессии (может быть любого типа)
	 * @return void
	 */
	protected function session(string $param, $val) :void
	{
		$_SESSION[$param] = $val;
	}

	//
	// Сохраняем просмотренные страницы в логи
	//
	protected function saveLogs()
	{
		$_SESSION['logs'][] = $_SERVER['REQUEST_URI'];
		if(count($_SESSION['logs']) > self::$constants['LOGS_AMOUNT']) {
			array_shift($_SESSION['logs']);
		}
	}

	/**
	 * функция запрета входа на страницу с установкой нужного сообщения и страницы редиректа
	 */
    public function redirect(string $message, string $redirect)
    {
        $this->flash($message);
        header("Location: /$redirect");
        exit;
    }

	//
	// Если вызвали метод, которого нет - завершаем работу
	//
	public function __call($name, $params){
        die('Не пишите фигню в url-адресе!!!');
	}
}
