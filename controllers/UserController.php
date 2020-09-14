<?php
namespace controllers;

use Illuminate\Support\Str;
use resources\Validator;

/**
 * Контроллер действий пользователя
 */
class UserController extends BaseController
{

	/**
	 * Страница входа на сайт '/user'
	 */
	public function login()
	{
		$this->active = 'login';

		if ($this->isPost()) { // проверка, вводил ли уже свои данные пользователь
			$this->user->clear($_POST);

			// var_dump($_POST);die;
			$login = $_POST['login'];
			$pass = $_POST['pass'];

			if ($this->user->isUserExists($login)) { // проверка, существует ли в базе данных этот логин
				$userData = $this->user->checkPass($login, $pass); // проверка пароля, если успешно, то получение данных пользователя
				// var_dump($userData);die;
				if ($userData['userId']) {
					$this->session('userId', $userData['userId']); // сохраняем userId в сессии
					$this->session('userLogin', $login); // сохраняем login в сессии
					if ($userData['userName']) {
						$this->session('userName', $userData['userName']); // если у пользователя имеется userName, то сохраняем в сессии
						$login = $userData['userName'];
					}
					$this->redirect(Str::of($login)->upper() . ', добро пожаловать на сайт!', 'phones');
				} else {
					$this->flash('Пароль не верен!');
				}
			} else {
				$this->flash('Нет такого пользователя!');
			}
		}

		echo $this->blade->render('pages/user/login', [
			'active' => $this->active,
			'login' => $login ?? ''
		]);
	}

	/**
	 * Страница регистрации нового пользоватея '/registry'
	 */
	public function reg()
	{
		$this->active = 'reg';

		if ($this->isPost()) { // проверка, вводил ли уже свои данные пользователь
			if($this->user->validating($_POST)) // валидация вводимых данных пользователем
			{
				// var_dump($_POST);die;
				$login = $_POST['login'];
				$pass = $_POST['pass'];
				if ($this->user->isUserExists($login)) { // проверка, существует ли уже пользователь с таким логином
					$this->flash('Пользователь с таким логином уже зарегистрирован!');
				} else {
					$userId = $this->user->createUser($login, $pass); // создание нового пользователя
					if ($userId) {
						$this->session('userId', $userId); // сохраняем userId в сессии
						$this->session('userLogin', $login); // сохраняем login в сессии
						$this->redirect('Вы успешно зарегистрировались!', 'phones');
					} else {
						$this->flash('Извините, по техническим причинам регистрация не доступна! Просьба, повторить чуть позже!');
					}
				}
			} else {
				$flash = Validator::getErrors(); // получение сообщений об ошибках ввода данных пользователем
				$this->flash(explode(', ', $flash));
			}
			// var_dump($login);die;
		}

		echo $this->blade->render('pages/user/registry', [
			'active' => $this->active,
			'login' => $login ?? '',
			'pass' => $pass ?? ''
		]);
	}

	/**
	 * функция выхода с сайта
	 */
	public function logout()
	{
		$this->user->destroy(); // удаление данных пользователя из сессии и куков

		$this->redirect('Вы успешно вышли!', 'phones');
	}

	/**
	 * страница личного кабинета пользователя
	 */
	public function cabinet()
	{
		$userData = $this->user->getUserData($_SESSION['userId']); // получение данных о пользователе

		echo $this->blade->render('pages/user/cabinet', [
			'userData' => $userData
		]);
	}

	/**
	 * функция изменения личных данных пользователя
	 */
	public function change()
	{
		$userData = $this->user->getUserData($_SESSION['userId']); // получение данных о пользователе

		// var_dump($_POST);die;
		if ($this->isPost()) { // проверка, вводил ли уже пользователь новые данные о себе
			$this->user->clear($_POST); // очищение вводимых пользователем данных
			$userData = $_POST;
			if ($this->user->changeUserData($userData)) { // изменение данных пользователя в базе данных
				$this->redirect('Ваши данные успешно изменились!', 'cabinet');
			} else {
				$this->flash('Извините, по техническим причинам изменение не доступно! Просьба, повторить чуть позже!');
			}
		}

		echo $this->blade->render('pages/user/change', [
			'userData' => $userData
		]);
	}

}
