<?php
namespace controllers;

use models\UserModel;
//
// Контроллер действий пользователя.
//
class UserController extends BaseController
{
	private $user;
	//
	// Конструктор.
	//
	public function __construct()
	{
		$this->user = new UserModel();
	}

	// public function action_auth()
	// {
	// 	$this->title .= '::Авторизация';

    //     if($this->IsPost()){
	// 		$userData['login'] = $_POST['login'] ?? '';
	// 		$userData['pass'] = $_POST['pass'] ?? '';
	// 		// var_dump($this->user->auth($userData));die;
	// 		if($this->user->auth($userData)) {
	// 			$_SESSION['isLogged'] = true;
	// 			$this->flashSet('Авторизация прошла успешно!');
	// 			header('Location: index.php');
	// 		} else {
	// 			$this->content = $this->Template('v/v_auth.php', [
	// 				'login' => $userData['login'],
	// 				'announce' => 'Некорректный ввод данных!'
	// 			]);
	// 		}
	// 	}
	// 	else{
	// 	   $this->content = $this->Template('v/v_auth.php');
	// 	}
	// }

	// public function action_reg()
	// {
	// 	$this->title .= '::Регистрация';

	// 	if ($this->IsPost()) {
	// 		$userData['name'] = $_POST['name'] ?? '';
	// 		$userData['login'] = $_POST['login'] ?? '';
	// 		$userData['pass'] = $_POST['pass'] ?? '';
	// 		if ($this->user->reg($userData)) {
	// 			$_SESSION['isLogged'] = true;
	// 			$this->flashSet('Регистрация прошла успешно!');
	// 			header('Location: index.php');
	// 		} else {
	// 			$this->content = $this->Template('v/v_reg.php', [
	// 				'userData' => $userData,
	// 				'announce' => 'Пользователь с таким логином уже существует!'
	// 			]);
	// 		}
	// 	} else {
	// 		$this->content = $this->Template('v/v_reg.php');
	// 	}
	// }

	public function action_cab()
	{
		$this->title .= '::Кабинет';

		$this->content = $this->Template('v/v_cab.php');
	}

	public function action_out()
	{
		unset($_SESSION['isLogged']);

		$this->flashSet('Вы успешно вышли из кабинета!');
		header('Location: index.php');
	}
}
