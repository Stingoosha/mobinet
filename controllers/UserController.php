<?php
namespace controllers;

use Illuminate\Support\Str;
use models\UserModel;
//
// Контроллер действий пользователя
//
class UserController extends BaseController
{
	private $user; // модель пользователя

	//
	// Конструктор
	//
	public function __construct()
	{
		// создается экземпляр модели пользователя
		$this->user = new UserModel();
	}

	/**
	 * страница входа на сайт '/auth'
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
				$userId = $this->user->checkPass($login, $pass);
				if ($userId) {
					$this->session('userId', $userId);
					$this->session('userLogin', $login);
					$this->redirect(Str::of($login)->upper() . ', Вы успешно вошли!', 'phones');
				} else {
					$this->flash('Извините, по техническим причинам вход на сайт не доступен! Просьба, повторить чуть позже!');
				}
			} else {
				$this->flash('Нет такого пользователя!');
			}
		}

		echo $this->blade->render('pages/login', [
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
				$this->flash($flash);
			}
			// var_dump($login);die;
		}

		echo $this->blade->render('pages/registry', [
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

		echo $this->blade->render('pages/cabinet', [
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

		echo $this->blade->render('pages/change', [
			'userData' => $userData
		]);
	}

}
