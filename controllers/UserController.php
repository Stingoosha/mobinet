<?php
namespace controllers;

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
	public function auth()
	{
		$this->active = 'auth';

		// TODO: сделать обработку формы входа на сайт

		echo $this->blade->render('pages/auth', [
			'active' => $this->active
		]);
	}

	/**
	 * страница регистрации нового пользоватея '/registry'
	 */
	public function reg()
	{
		$this->active = 'reg';

		if ($this->isPost()) {
			$login = $_POST['login'];
			$pass = $_POST['pass'];
			// var_dump($login);die;
			if ($this->user->isUserExists($login)) {
				$this->flash('Пользователь с таким логином уже зарегистрирован!');
			} else {
				$userId = $this->user->createUser($login, $pass);
				if ($userId) {
					$this->session('userId', $userId);
					$this->session('userLogin', $login);
					$this->redirect('Вы успешно зарегистрировались!', 'phones');
				} else {
					$this->flash('Извините, из-за технических проблем регистрация не удалась! Просьба, повторить чуть позже!');
				}
			}
		}

		echo $this->blade->render('pages/registry', [
			'active' => $this->active,
			'login' => $login ?? '',
			'pass' => $pass ?? ''
		]);
	}

}
