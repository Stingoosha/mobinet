<?php
// подгружаем и активируем авто-загрузчик
require_once 'vendor/autoload.php';

// автоматическое подключение классов
spl_autoload_register(function ($classname) {
	include_once("$classname.php");
});

// подгружаем пприложение
use resources\App;
// подгружаем роутер
use resources\Router;

// var_dump($GLOBALS);die;

try {

	// инициализация приложения (руты, константы, база данных, валидация)
	App::init('configs/routes.php', 'configs/constants.php', 'configs/database.php', 'configs/validation.php');
	// по заданному URL находим массив с контроллером и его методом
	$routingData = Router::routing($_SERVER['PHP_SELF']);
	// var_dump($routingData);die;
	// вытаскиваем название контроллера
	$controller = $routingData[0];
	// вытаскиваем название метода
	$action = $routingData[1];
	// запускаем нужный request
	$controller->Request($action);

} catch (Exception $e) {

  	die ('ERROR: ' . $e->getMessage());

}
