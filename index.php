<?php
// подгружаем и активируем авто-загрузчик
require_once 'vendor/autoload.php';

// автоматическое подключение классов
spl_autoload_register(function ($classname) {
	include_once("$classname.php");
});

// подгружаем роутер
use resources\Router;

// var_dump($GLOBALS);die;

try {

	// устанавливаем путь до файла с рутами
	Router::setRoutePath('configs/routes.php');
	// по заданному URL находим массив с контроллером и его методом
	$routingData = Router::routing($_SERVER['PHP_SELF']);

	// var_dump($routingData);die;
	// вытаскиваем название контроллера
	$controller = $routingData[0];
	// вытаскиваем название метода и добавляем приставку 'action_'
	$action = $routingData[1];
	// запускаем нужный request
	$controller->Request($action);

} catch (Exception $e) {

  	die ('ERROR: ' . $e->getMessage());

}
