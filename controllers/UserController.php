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

		// TODO: сделать обработку формы регистрации нового пользователя

		echo $this->blade->render('pages/registry', [
			'active' => $this->active
		]);
	}

}
