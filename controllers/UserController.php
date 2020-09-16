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
				if ($userData['userId']) {
					if ($_POST['remember']) { // если отмечен checkbox "Запомнить на 1 год"
						$pcName = php_uname('n');
						$pcType = php_uname('m');
						$wName = php_uname('v');
						$coockiData = $userData['userId'] . ':' . password_hash($login . $pcName . $pcType . $wName, PASSWORD_BCRYPT);
						// var_dump($coockiData);die;
						$this->cookie('remember', $coockiData, self::$constants['YEAR']); // сохраняем userId в куках на 1 год
					}
					$this->session('userId', $userData['userId']); // сохраняем userId в сессии
					if ($userData['userName']) {
						$login = $userData['userName']; // если у пользователя указано имя, то будем приветствовать его по имени
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
			'userData' => $this->userData,
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
						$this->redirect($login . ', Вы успешно зарегистрировались!', 'login');
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
			'userData' => $this->userData,
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
		$this->destroy(); // удаление данных пользователя из сессии и кук

		$this->redirect('Вы успешно вышли!', 'phones');
	}

	/**
	 * страница личного кабинета пользователя
	 */
	public function cabinet()
	{
		echo $this->blade->render('pages/user/cabinet', [
			'userData' => $this->userData
		]);
	}

	/**
	 * функция изменения личных данных пользователя
	 */
	public function edit()
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
			'userData' => $this->userData
		]);
	}

	/**
	 * Функция удаления данных из сессии при логауте пользователя
	 * @return void
	 */
	public function destroy() :void
	{
		unset($_SESSION['userId']);

		$this->cookie('remember', '123', -3600);
	}

}
