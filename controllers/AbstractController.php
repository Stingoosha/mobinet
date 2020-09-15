<?php
namespace controllers;

/**
 * Базовый класс контроллера
 */
abstract class AbstractController
{
	/**
	 * Массив констант
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
	 * Функция возврата массива констант
	 */
	public static function getConstants()
	{
		return self::$constants;
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

	/**
	 * Функция установки переменной куки
	 * @var string $param Название переменной куки
	 * @var $val Значение, сохраняемое в переменной куки (может быть любого типа)
	 * @return void
	 */
	protected function coockie(string $param, $val, int $period ) :void
	{
		setcookie($param, $val, time() + $period);
	}

	/**
	 * Сохраняем просмотренные страницы в логи
	 * @return void
	 */
	protected function saveLogs() :void
	{
		$_SESSION['logs'][] = $_SERVER['REQUEST_URI'];
		if(count($_SESSION['logs']) > self::$constants['LOGS_AMOUNT']) {
			array_shift($_SESSION['logs']);
		}
	}

	/**
	 * Функция перехода на другую страницу с каким-либо сообщением
	 * @var string $message Сообщение, выводимое под менюшкой
	 * @var string $redirect Страница, куда произойдет редирект
	 * @return void
	 */
    public function redirect(string $message, string $redirect) :void
    {
        $this->flash($message);
        header("Location: /$redirect");
        exit;
    }

	/**
	 * Если вызвали метод, которого нет - завершаем работу (оставил, чтоб видеть когда роутер поломается)
	 * @var string $name Название метода, которого нет
	 * @var array $params Массив параметров, переданных в метод, которого нет
	 */
	public function __call(string $name, array $params = []){
        die('Не пишите фигню в url-адресе!!!');
	}
}
