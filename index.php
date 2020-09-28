<?php
/**
 * @author Сергей <sergeyka1974@mail.ru>
 * @version 1.0
 */

/**
 * подгружаем и активируем авто-загрузчик
 */
require_once 'vendor/autoload.php';

/**
 * автоматическое подключение классов
 */
spl_autoload_register(function ($classname) {
	include_once("$classname.php");
});

/**
 * подгружаем класс приложения
 */
use resources\App;
/**
 * подгружаем класс роутера
 */
use resources\Router;

// var_dump($GLOBALS);die;

try {

	/**
	 * инициализируем приложение (указываем пути до данных с маршрутизацией, константами, по базе данных, с правилами валидации)
	 */
	App::init('configs/routes.php', 'configs/constants.php', 'configs/access.php', 'configs/database.php', 'configs/validation.php');
	/**
	 * по заданному URL находим массив с контроллером и его методом
	 */
	$routingData = Router::routing($_SERVER['PHP_SELF']);
	// var_dump($routingData);die;
	/**
	 * вытаскиваем название контроллера из $routingData
	 */
	$controller = new $routingData[0];
	/**
	 * вытаскиваем название метода из $routingData
	 */
	$action = $routingData[1];
	/**
	 * запускаем нужный Request
	 */
	$controller->Request($action);

} catch (Exception $e) {

  	die ('ERROR: ' . $e->getMessage());

}
