<?php
namespace controllers;

use Illuminate\Support\Str;
use resources\Validator;
//
// Контроллер действий пользователя
//
class UserController extends BaseController
{

	/**
	 * страница входа на сайт '/user'
	 */
	public function login()
	{
		$this->active = 'login';

		if ($this->isPost()) {
			$this->user->clear($_POST);

			// var_dump($_POST);die;
			$login = $_POST['login'];
			$pass = $_POST['pass'];

			if ($this->user->isUserExists($login)) {
				$userData = $this->user->checkPass($login, $pass);
				// var_dump($userData);die;
				if ($userData['userId']) {
					$this->session('userId', $userData['userId']);
					$this->session('userLogin', $login);
					if ($userData['userName']) {
						$this->session('userName', $userData['userName']);
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
	 * страница регистрации нового пользоватея '/registry'
	 */
	public function reg()
	{
		$this->active = 'reg';

		if ($this->isPost()) {
			if($this->user->validating($_POST))
			{
				// var_dump($_POST);die;
				$login = $_POST['login'];
				$pass = $_POST['pass'];
				if ($this->user->isUserExists($login)) {
					$this->flash('Пользователь с таким логином уже зарегистрирован!');
				} else {
					$userId = $this->user->createUser($login, $pass);
					if ($userId) {
						$this->session('userId', $userId);
						$this->session('userLogin', $login);
						$this->redirect('Вы успешно зарегистрировались!', 'phones');
					} else {
						$this->flash('Извините, по техническим причинам регистрация не доступна! Просьба, повторить чуть позже!');
					}
				}
			} else {
				$flash = Validator::getErrors();
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
		$this->user->destroy();

		$this->redirect('Вы успешно вышли!', 'phones');
	}

	/**
	 * страница личного кабинета пользователя
	 */
	public function cabinet()
	{
		$userData = $this->user->getUserData($_SESSION['userId']);

		echo $this->blade->render('pages/user/cabinet', [
			'userData' => $userData
		]);
	}

	/**
	 * функция изменения личных данных пользователя
	 */
	public function change()
	{
		$userData = $this->user->getUserData($_SESSION['userId']);

		// var_dump($_POST);die;
		if ($this->isPost()) {
			$this->user->clear($_POST);
			$userData = $_POST;
			if ($this->user->changeUserData($userData)) {
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
